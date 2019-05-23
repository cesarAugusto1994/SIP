<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class CourseForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', Field::TEXT, [
                'rules' => 'required|min:5',
                'label' => 'Titulo'
            ])
            ->add('workload', 'number', [
                'rules' => 'required|min:5',
                'label' => 'Carga Horária'
            ])
            ->add('description', Field::TEXTAREA, [
                'rules' => 'max:5000',
                'attr' => ['class' => 'summernote'],
                'label' => 'Descrição'
            ])
            ->add('grade', Field::TEXTAREA, [
                'rules' => 'max:5000',
                'attr' => ['class' => 'summernote'],
                'label' => 'Grade Curricular'
            ])
            ->add('submit', 'submit', [
              'label' => 'Salvar',
              'attr' => ['class' => 'btn btn-success'],
            ]);
    }
}
