@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <create-group :initial-users="{{ $users }}"></create-group>
            </div>
            <div class="col-sm-6">
                <groups :initial-groups="{{ $groups }}" :user="{{ $user }}"></groups>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-heading py-2 text-center">
                        <h5>Let's Chats</h5>
                    </div>
                    <div class="card-body">
                        <chat-messages :messages="messages" :user="{{ Auth::user() }}"></chat-messages>
                    </div>
                    <div class="card-footer">
                        <chat-form v-on:messagesent="addMessage" :user="{{ Auth::user() }}"></chat-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
