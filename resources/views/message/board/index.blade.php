@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Mural de Recados</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Mural de Recados</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card">
        <!-- Email-card start -->
        <div class="card-block email-card">

            <div class="row">

                <div class="col-lg-12 col-xl-12">

                  <div class="mail-body">
                      <div class="mail-body-header">
                          <a href="{{route('message-board.create')}}" class="btn btn-success btn-round btn-xs waves-effect waves-light">
                                <i class="icofont icofont-exclamation-circle"></i> Novo Recado
                          </a>
                      </div>
                      <div class="mail-body-content">
                          <div class="table-responsive">
                              <table class="table">
                                <tbody>
                                  @foreach($messages as $message)
                                    <tr class="read">
                                        <td><a href="{{ route('message-board.show', $message->uuid) }}" class="email-name">
                                          <img src="{{ route('image', ['user' => $message->user->uuid, 'link' =>  $message->user->avatar, 'avatar' => true])}}"
                                          alt="contact-img" title="contact-img" class="img-radius img-40 align-top m-r-15">
                                          {{ $message->user->person->name ?? '' }}</a>
                                        </td>
                                        <td><a href="{{ route('message-board.show', $message->uuid) }}" class="email-name">{{ $message->subject }}<br/>
                                            <span class="label label-{{ array_random(['info', 'success', 'primary', 'danger']) }}">{{ $message->type->name }}</span>
                                        </a></td>
                                        <td class="email-attch">
                                          @if($message->attachments->isNotEmpty())
                                            <i class="fa fa-paperclip"></i>
                                          @endif
                                        </td>
                                        <td class="email-time">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                  @endforeach

                              </tbody>
                            </table>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
