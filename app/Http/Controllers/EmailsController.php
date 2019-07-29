<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Client;
use App\Models\Email;
use App\Models\Email\{From,To,Cc,Bcc,ReplayTo,Sender,Contact,Attachment,Folder};
use App\User;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailsInbox = Email::where('folder_id', 2)->orderByDesc('id')->paginate();
        $emailsSent = Email::where('folder_id', 4)->get();
        $emailsDraft = Email::where('folder_id', 5)->get();
        $emailsTrash = Email::where('folder_id', 3)->get();
        $emailsInboxUnSeen = Email::where('flag_seen', false)->count();

        return view('email.index', compact('emailsInbox', 'emailsSent', 'emailsDraft', 'emailsTrash', 'emailsInboxUnSeen'));
    }

    public function html($id)
    {
        $email = Email::uuid($id);
        return $email->html;
    }

    public function search()
    {
        $user = auth()->user();

        if(empty($user->password_email)) {

          notify()->flash('E-mail inacessível!', 'success', [
            'text' => 'Informe a senha do seu e-mail nas configurações do seu perfil.'
          ]);

          return back();
        }

        $hasRecent = false;

        $oClient = new Client([
            'host'          => 'imap.umbler.com',
            'port'          => 143,
            'encryption'    => 'tls',
            'validate_cert' => false,
            'username'      => $user->email,
            'password'      => $user->password_email,
            'protocol'      => 'imap'
        ]);

        $connected = $oClient->connect();

        $reflectionClass = new \ReflectionClass(get_class($connected));
        $cennection = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $cennection[$property->getName()] = $property->getValue($connected);
            $property->setAccessible(false);
        }

        if($cennection['connected']) {

            $folders = $oClient->getFolders();

            foreach ($folders as $key => $folder) {

                $folder2 = Folder::where('name', $folder->name)->first();

                if(!$folder2) {
                    $folder2 = Folder::create([
                        'name' => $folder->name,
                        'path' => $folder->path,
                        'full_name' => $folder->full_name,
                        'delimiter' => $folder->delimiter,
                        'no_inferiors' => $folder->no_inferiors,
                        'no_select' => $folder->no_select,
                        'marked' => $folder->marked,
                        'has_children' => $folder->has_children,
                        'referal' => $folder->referal,
                    ]);
                }

                //$messages = $folder->query()->since(now()->subDays(1))->get();

                $messages = $folder->messages()->all()->get();

                foreach ($messages as $key => $message) {

                    $reflectionClass = new \ReflectionClass(get_class($message));
                    $msg = array();
                    foreach ($reflectionClass->getProperties() as $property) {
                        $property->setAccessible(true);
                        $msg[$property->getName()] = $property->getValue($message);
                        $property->setAccessible(false);
                    }

                    $hasEmail = Email::where('message_id', $msg['attributes']['message_id'])->get();

                    if($hasEmail->isEmpty()) {

                        $hasRecent = true;

                        $flags = $msg['flags']->toArray();

                        $data = [
                            'user_id' => $user->id,
                            'folder_id' => $folder2->id,
                            'message_id' => $msg['attributes']['message_id'],
                            'message_no' => $msg['attributes']['message_no'],
                            'subject' => $msg['attributes']['subject'],
                            'references' => $msg['attributes']['references'],
                            'date' => $msg['attributes']['date'],
                            'in_reply_to' => $msg['attributes']['in_reply_to'],

                            'priority' => !is_array($msg['attributes']['priority']) ? (int)$msg['attributes']['priority'] : 0,

                            'msglist' => $msg['attributes']['msglist'],
                            'uid' => $msg['attributes']['uid'],
                            'msgn' => $msg['attributes']['msgn'],

                            'folder_path' => $msg['folder_path'],
                            'fetch_options' => $msg['fetch_options'],
                            'fetch_body' => $msg['fetch_body'],
                            'fetch_attachment' => $msg['fetch_attachment'],
                            'fetch_flags' => $msg['fetch_flags'],

                            'header' => $msg['header'],
                            'header_info' => $msg['header_info'],
                            'raw_body' => $msg['raw_body'],
                            'text' => $msg['bodies']['text']->content ?? '',
                            'html' => $msg['bodies']['html']->content ?? '',

                            'flag_recent' => (boolean)$flags['recent'],
                            'flag_flagged' => (boolean)$flags['flagged'],
                            'flag_answered' => (boolean)$flags['answered'],
                            'flag_deleted' => (boolean)$flags['deleted'],
                            'flag_seen' => (boolean)$flags['seen'],
                            'flag_draft' => (boolean)$flags['draft'],
                        ];

                        $email = Email::create($data);

                        foreach ($msg['attributes']['from'] as $key => $from) {

                          $contact = Contact::where('mail', $from->mail)->first();

                          if(!$contact) {
                              $contact = Contact::create([
                                  'user_id' => $user->id,
                                  'mail' => $from->mail,
                                  'personal' => $from->personal,
                                  'mailbox' => $from->mailbox,
                                  'host' => $from->host,
                                  'full' => $from->full,
                              ]);
                          }

                          From::create([
                            'email_id' => $email->id,
                            'contact_id' => $contact->id,
                          ]);

                        }

                        foreach ($msg['attributes']['to'] as $key => $to) {

                          $contact = Contact::where('mail', $to->mail)->first();

                          if(!$contact) {
                              $contact = Contact::create([
                                  'user_id' => $user->id,
                                  'mail' => $to->mail,
                                  'personal' => $to->personal,
                                  'mailbox' => $to->mailbox,
                                  'host' => $to->host,
                                  'full' => $to->full,
                              ]);
                          }

                          To::create([
                            'email_id' => $email->id,
                            'contact_id' => $contact->id,
                          ]);

                        }

                        foreach ($msg['attributes']['cc'] as $key => $cc) {

                          $contact = Contact::where('mail', $cc->mail)->first();

                          if(!$contact) {
                              $contact = Contact::create([
                                  'user_id' => $user->id,
                                  'mail' => $cc->mail,
                                  'personal' => $cc->personal,
                                  'mailbox' => $cc->mailbox,
                                  'host' => $cc->host,
                                  'full' => $cc->full,
                              ]);
                          }

                          Cc::create([
                            'email_id' => $email->id,
                            'contact_id' => $contact->id,
                          ]);

                        }

                        foreach ($msg['attributes']['bcc'] as $key => $bcc) {

                          $contact = Contact::where('mail', $bcc->mail)->first();

                          if(!$contact) {
                              $contact = Contact::create([
                                  'user_id' => $user->id,
                                  'mail' => $bcc->mail,
                                  'personal' => $bcc->personal,
                                  'mailbox' => $bcc->mailbox,
                                  'host' => $bcc->host,
                                  'full' => $bcc->full,
                              ]);
                          }

                          Bcc::create([
                            'email_id' => $email->id,
                            'contact_id' => $contact->id,
                          ]);

                        }

                        foreach ($msg['attributes']['reply_to'] as $key => $replayTo) {

                          $contact = Contact::where('mail', $replayTo->mail)->first();

                          if(!$contact) {
                              $contact = Contact::create([
                                  'user_id' => $user->id,
                                  'mail' => $replayTo->mail,
                                  'personal' => $replayTo->personal,
                                  'mailbox' => $replayTo->mailbox,
                                  'host' => $replayTo->host,
                                  'full' => $replayTo->full,
                              ]);
                          }

                          ReplayTo::create([
                            'email_id' => $email->id,
                            'contact_id' => $contact->id,
                          ]);

                        }

                        foreach ($msg['attributes']['sender'] as $key => $sender) {

                          $contact = Contact::where('mail', $sender->mail)->first();

                          if(!$contact) {
                              $contact = Contact::create([
                                  'user_id' => $user->id,
                                  'mail' => $sender->mail,
                                  'personal' => $sender->personal,
                                  'mailbox' => $sender->mailbox,
                                  'host' => $sender->host,
                                  'full' => $sender->full,
                              ]);
                          }

                          Sender::create([
                            'email_id' => $email->id,
                            'contact_id' => $contact->id,
                          ]);

                        }

                        //$attachments = $msg['attachments']->toArray();

                        $attachments = $message->getAttachments();

                        foreach ($attachments as $key => $attachment) {

                          $attachment->save();

                          $attach = Attachment::where('name', $attachment->name)->first();

                          if(!$attach) {
                              $attach = Attachment::create([
                                  'email_id' => $email->id,
                                  'attechment_id' => $attachment->id,
                                  'name' => $attachment->name,
                                  'content' => $attachment->content,
                                  'type' => $attachment->type,
                                  'content_type' => $attachment->content_type,
                                  'part_number' => $attachment->part_number,
                                  'disposition' => $attachment->disposition,
                                  'img_src' => $attachment->img_src,
                              ]);
                          }



                        }

                    }

                }

            }

        }

        return response()->json([
          'success' => true,
          'novos E-mails encontrados'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('email.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Email::uuid($id);

        $oClient = new Client([
            'host'          => 'imap.umbler.com',
            'port'          => 143,
            'encryption'    => 'tls',
            'validate_cert' => false,
            'username'      => 'cesar.sousa@provider-es.com.br',
            'password'      => 'Provider@123',
            'protocol'      => 'imap'
        ]);

        $oClient->connect();

        $oFolder = $oClient->getFolder('INBOX');

        $email->flag_seen = 1;
        $email->save();

        $oMessage = $oFolder->getMessage($email->uid);

        $oMessage->setFlag(['Seen']);

        $from = $email->from->first();

        $avatar = "";

        if($from) {

          $from->contact->mail;

          $user = User::where('email', $from->contact->mail)->first();

          if($user) {
            $avatar = route('image', ['user' => $user->uuid, 'link' => $user->avatar, 'avatar' => true]);
          }

        }

        return view('email.show', compact('email', 'avatar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
