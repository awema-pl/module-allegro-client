<?php

return [
   'admin' => [
       'installation' => [
           'default_setting' =>[
               'attributes' =>[
                   'default_client_id' => 'domyślny ID klienta',
                   'default_client_secret' =>'domyślny sekretny klucz klienta',
               ]
           ]
       ],
       'setting'=>[
           'attributes' => [
               'key' => 'klucz',
               'value' => 'wartość',
           ],
           'messages'=>[

           ]
       ],
   ],
   'user' =>[
       'account'=>[
           'attributes' => [
               'application' => 'aplikacja',
           ],
           'messages'=>[
               'application_required' => 'Wybierz aplikację',
           ]
       ],
       'application'=>[
           'attributes' => [
               'name' => 'nazwa',
               'client_id' => 'ID klienta',
               'client_secret' => 'sekretny klucz klienta',
           ],
           'messages'=>[
               'client_id_required' => 'Pole klient ID jest wymagane',
               'client_secret_required' => 'Pole sekretny klucz klienta jest wymagane',
           ]
       ],
   ],
];
