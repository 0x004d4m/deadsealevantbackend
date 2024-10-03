<?php

return array (
  'show_translatable_field_icon' => true,
  'translatable_field_icon_position' => 'right',
  'locales' => 
  array (
    'ar' => 'Arabic',
    'en' => 'English',
    'es' => 'Spanish',
    'FR' => 'French',
  ),
  'view_namespaces' => 
  array (
    'buttons' => 
    array (
      0 => 'crud::buttons',
    ),
    'columns' => 
    array (
      0 => 'crud::columns',
    ),
    'fields' => 
    array (
      0 => 'crud::fields',
    ),
    'filters' => 
    array (
      0 => 'crud::filters',
    ),
  ),
  'uploaders' => 
  array (
    'withFiles' => 
    array (
      'image' => 'Backpack\\CRUD\\app\\Library\\Uploaders\\SingleBase64Image',
      'upload' => 'Backpack\\CRUD\\app\\Library\\Uploaders\\SingleFile',
      'upload_multiple' => 'Backpack\\CRUD\\app\\Library\\Uploaders\\MultipleFiles',
    ),
  ),
  'file_name_generator' => 'Backpack\\CRUD\\app\\Library\\Uploaders\\Support\\FileNameGenerator',
);
