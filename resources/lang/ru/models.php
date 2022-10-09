<?php

return [
    'patient' => [
        'labels' => [
            'label' => 'Пациент',
            'set' => 'Выбрать пациента',
            'select' => 'Выберите пациента...',
            'selected' => 'Выбранный пациент',
        ],
    ],

    'mod' => [
        'labels' => [
            'label' => 'Процедура',
            'set' => 'Выбрать модуль',
            'select' => 'Выберите модуль...',
            'selected' => 'Выбранный модуль',
        ],

        'actions' => [
            'create' => 'Создать модуль',
        ],
    ],

    'task_for_patient' => [
        'labels' => [
            'list' => 'Предыдущие процедуры',
        ],
    ],

    'file_for_mods' => [
        'labels' => [
            'label' => 'Список файлов для модуля',
            'file_list_empty' => 'Список файлов пуст...',
            'already_attached' => 'Файл уже добавлен',
        ],
        'actions' => [
            'attach' => 'Прикрепить файл',
            'detach' => 'Открепить файл',
        ],
    ],
];
