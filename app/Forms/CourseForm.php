<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class CourseForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('Titulo', Field::TEXT, [
                'rules' => 'required|min:5'
            ])
            ->add('Carga Horária', Field::TEXT, [
                'rules' => 'required|min:5'
            ])
            ->add('Descrição', Field::TEXTAREA, [
                'rules' => 'max:5000'
            ])
            ->add('Grade Curricular', Field::TEXTAREA, [
                'rules' => 'max:5000'
            ])
            ->add('submit', 'submit', ['label' => 'Salvar', 'class' => 'btn-inverse']);
    }
}
