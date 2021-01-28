@extends('indigo-layout::installation')

@section('meta_title', _p('allegro-client::pages.admin.installation.default_setting.meta_title', 'Installation module Allegro') . ' - ' . config('app.name'))
@section('meta_description', _p('allegro-client::pages.admin.installation.default_setting.meta_description', 'Installation module Allegro client in application'))

@push('head')

@endpush

@section('title')
    <h2>{{ _p('allegro-client::pages.admin.installation.default_setting.headline', 'Installation module Allegro') }}</h2>
@endsection

@section('content')
    <form-builder disabled-dialog="" url="{{ route('allegro_client.admin.installation.store_default_setting') }}" send-text="{{ _p('allegro-client::pages.admin.installation.default_setting.send_text', 'Install') }}"
    edited>
        <div class="section">
            {{ _p('allegro-client::pages.admin.installation.default_setting.installing_default_settings', 'Installing default settings.') }}
        </div>
        <div class="section">
           <fb-input name="default_client_id" label="{{ _p('allegro-client::pages.admin.installation.default_setting.default_client_id', 'Default client ID') }}"></fb-input>
            <fb-input name="default_client_secret" label="{{ _p('allegro-client::pages.admin.installation.default_setting.default_client_secret', 'Default client secret') }}"></fb-input>
            <small class="cl-caption">
                {!! _p('allegro-client::pages.admin.installation.default_setting.generate_client_data', 'Generate client data at <a href=":url" target="_blank">this</a> address.', ['url' =>'https://apps.developer.allegro.pl/new']) !!}
            </small>
        </div>
    </form-builder>
@endsection
