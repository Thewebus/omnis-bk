<div class="chat" wire:poll="refreshMessage">
    <!-- chat-header start-->
    <div class="media chat-header clearfix">
        <img class="rounded-circle" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
        <div class="media-body">
            <div class="about">
                <div class="name">{{ Auth::user()->fullname }}
                    {{-- <img class="img-90 rounded-circle" src="http://localhost:8000/assets/images/dashboard/1.png" alt=""> --}}
                    {{-- <span class="font-primary f-12">Typing...</span> --}}
                </div>
                {{-- <div class="status digits">Last Seen 3:55 PM</div> --}}
            </div>
        </div>
        {{-- <ul class="list-inline float-start float-sm-end chat-menu-icons">
            <li class="list-inline-item">
                <a href="javascript:void(0)"><i class="icon-search"></i></a>
            </li>
            <li class="list-inline-item">
                <a href="javascript:void(0)"><i class="icon-clip"></i></a>
            </li>
            <li class="list-inline-item">
                <a href="javascript:void(0)"><i class="icon-headphone-alt"></i></a>
            </li>
            <li class="list-inline-item">
                <a href="javascript:void(0)"><i class="icon-video-camera"></i></a>
            </li>
            <li class="list-inline-item toogle-bar">
                <a href="javascript:void(0)"><i class="icon-menu"></i></a>
            </li>
        </ul> --}}
    </div>
    <!-- chat-header end-->
    <div class="chat-history chat-msg-box custom-scrollbar" id="chat">
        <ul>
            @foreach ($messages as $message)
                @if ($message->chat_messageable_id == Auth::id())
                    <li class="clearfix">
                        <div class="message other-message pull-right">
                            <img class="rounded-circle float-end chat-user-img img-30" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
                            <div class="message-data"><span class="message-data-time">{{ $message->created_at->diffForHumans(null, false, false) }}</span></div>
                            {{ $message->message }}
                            <span class="autor-name">{{ $message->messageable->fullname }}</span>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="message my-message">
                            <img class="rounded-circle float-start chat-user-img img-30" src="{{asset('assets/images/dashboard/1.png')}}" alt="" />
                            <div class="message-data text-end"><span class="message-data-time">{{ $message->created_at->diffForHumans(null, false, false) }}</span></div>
                            {{ $message->message }}
                            <span class="autor-name">{{ $message->messageable->fullname }}</span>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <!-- end chat-history-->
    <div class="chat-message clearfix">
        <div class="row">
            <div class="col-xl-12 d-flex">
                {{-- <div class="smiley-box bg-primary">
                    <div class="picker"><img src="{{asset('assets/images/smiley.png')}}" alt="" /></div>
                </div> --}}
                <div class="input-group text-box">
                    <input class="form-control input-txt-bx" id="message-to-send" wire:keydown.enter="postMessage" type="text" wire:model="message" placeholder="Écrivez un message..." />
                    <button class="btn btn-primary input-group-text" wire:click="postMessage" type="button"><i class="fa fa-send"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!-- end chat-message-->
    <!-- chat end-->
    <!-- Chat right side ends-->
</div>