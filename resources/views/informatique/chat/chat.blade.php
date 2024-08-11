@extends("layouts.$master.master")

@section('title')Chat App
 {{ $title }}
@endsection

@push('css')
@livewireStyles
<style>
	.autor-name {
		font-size: 10px;
		position: relative;
		top: 30px;
		float: right;
	}
</style>
@endpush

@section('content')
	@component("components.$master.breadcrumb")
		@slot('breadcrumb_title')
			<h3>Chat App</h3>
		@endslot
		<li class="breadcrumb-item">Chat</li>
		{{-- <li class="breadcrumb-item">Data Tables</li> --}}
		{{-- <li class="breadcrumb-item active">Liste des classes</li> --}}
	@endcomponent
	
	<div class="container-fluid">
	    <div class="row">
	        {{-- <div class="col call-chat-sidebar">
	            <div class="card">
	                <div class="card-body chat-body">
	                    <div class="chat-box">
	                        <!-- Chat left side Start-->
	                        <div class="chat-left-aside">
	                            <div class="media">
	                                <img class="rounded-circle user-image" src="{{asset('assets/images/user/12.png')}}" alt="" />
	                                <div class="media-body">
	                                    <div class="about">
	                                        <div class="name f-w-600">Mark Jecno</div>
	                                        <div class="status">Status...</div>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="people-list" id="people-list">
	                                <div class="search">
	                                    <form class="theme-form">
	                                        <div class="form-group"><input class="form-control" type="text" placeholder="search" /><i class="fa fa-search"></i></div>
	                                    </form>
	                                </div>
	                                <ul class="list custom-scrollbar">
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/1.jpg')}}" alt="" />
	                                            <div class="status-circle away"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Vincent Porter</div>
	                                                    <div class="status">Hello Name</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/2.png')}}" alt="" />
	                                            <div class="status-circle online"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Aiden Chavez</div>
	                                                    <div class="status">Out is my favorite.</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/8.jpg')}}" alt="" />
	                                            <div class="status-circle online"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Prasanth Anand</div>
	                                                    <div class="status">Change for anyone.</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/4.jpg')}}" alt="" />
	                                            <div class="status-circle offline"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Venkata Satyamu</div>
	                                                    <div class="status">First bun like a sun.</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/5.jpg')}}" alt="" />
	                                            <div class="status-circle online"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Ginger Johnston</div>
	                                                    <div class="status">it's my life. Mind it.</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/8.jpg')}}" alt="" />
	                                            <div class="status-circle offline"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Kori Thomas</div>
	                                                    <div class="status">Change for anyone.</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/1.jpg')}}" alt="" />
	                                            <div class="status-circle online"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Vincent Porter</div>
	                                                    <div class="status">Hello Name</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                    <li class="clearfix">
	                                        <div class="media">
	                                            <img class="rounded-circle user-image" src="{{asset('assets/images/user/8.jpg')}}" alt="" />
	                                            <div class="status-circle online"></div>
	                                            <div class="media-body">
	                                                <div class="about">
	                                                    <div class="name">Kori Thomas</div>
	                                                    <div class="status">Change for anyone.</div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </li>
	                                </ul>
	                            </div>
	                        </div>
	                        <!-- Chat left side Ends-->
	                    </div>
	                </div>
	            </div>
	        </div> --}}
	        <div class="col call-chat-body">
	            <div class="card">
	                <div class="card-body p-0">
	                    <div class="row chat-box">
	                        <!-- Chat right side start-->
	                        <div class="col chat-right-aside">
	                            <!-- chat start-->
	                            
								<livewire:chat-app>

	                        </div>
	                        {{-- <div class="col chat-menu">
	                            <ul class="nav nav-tabs border-tab nav-primary" id="info-tab" role="tablist">
	                                <li class="nav-item">
	                                    <a class="nav-link active" id="info-home-tab" data-bs-toggle="tab" href="#info-home" role="tab" aria-selected="true">CALL</a>
	                                    <div class="material-border"></div>
	                                </li>
	                                <li class="nav-item">
	                                    <a class="nav-link" id="profile-info-tab" data-bs-toggle="tab" href="#info-profile" role="tab" aria-selected="false">STATUS</a>
	                                    <div class="material-border"></div>
	                                </li>
	                                <li class="nav-item">
	                                    <a class="nav-link" id="contact-info-tab" data-bs-toggle="tab" href="#info-contact" role="tab" aria-selected="false">PROFILE</a>
	                                    <div class="material-border"></div>
	                                </li>
	                            </ul>
	                            <div class="tab-content" id="info-tabContent">
	                                <div class="tab-pane fade show active" id="info-home" role="tabpanel" aria-labelledby="info-home-tab">
	                                    <div class="people-list">
	                                        <ul class="list digits custom-scrollbar">
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image" src="{{asset('assets/images/user/4.jpg')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">Erica Hughes</div>
	                                                            <div class="status"><i class="fa fa-share font-success"></i> 5 May, 4:40 PM</div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image mt-0" src="{{asset('assets/images/user/1.jpg')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">
	                                                                Vincent Porter
	                                                                <div class="status"><i class="fa fa-reply font-danger"></i> 5 May, 5:30 PM</div>
	                                                            </div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image" src="{{asset('assets/images/user/8.jpg')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">Kori Thomas</div>
	                                                            <div class="status"><i class="fa fa-share font-success"></i> 1 Feb, 6:56 PM</div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image" src="{{asset('assets/images/user/2.png')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">Aiden Chavez</div>
	                                                            <div class="status"><i class="fa fa-reply font-danger"></i> 3 June, 1:22 PM</div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image" src="{{asset('assets/images/user/4.jpg')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">Erica Hughes</div>
	                                                            <div class="status"><i class="fa fa-share font-success"></i> 5 May, 4:40 PM</div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image mt-0" src="{{asset('assets/images/user/1.jpg')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">Vincent Porter</div>
	                                                            <div class="status"><i class="fa fa-share font-success"></i> 5 May, 5:30 PM</div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image" src="{{asset('assets/images/user/8.jpg')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">Kori Thomas</div>
	                                                            <div class="status"><i class="fa fa-reply font-danger"></i> 1 Feb, 6:56 PM</div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                            <li class="clearfix">
	                                                <div class="media">
	                                                    <img class="rounded-circle user-image" src="{{asset('assets/images/user/4.jpg')}}" alt="" />
	                                                    <div class="media-body">
	                                                        <div class="about">
	                                                            <div class="name">Erica Hughes</div>
	                                                            <div class="status"><i class="fa fa-share font-success"></i> 5 May, 4:40 PM</div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </li>
	                                        </ul>
	                                    </div>
	                                </div>
	                                <div class="tab-pane fade" id="info-profile" role="tabpanel" aria-labelledby="profile-info-tab">
	                                    <div class="people-list">
	                                        <div class="search">
	                                            <form class="theme-form">
	                                                <div class="form-group"><input class="form-control" type="text" placeholder="Write Status..." /><i class="fa fa-pencil"></i></div>
	                                            </form>
	                                        </div>
	                                    </div>
	                                    <div class="status">
	                                        <p class="font-primary f-w-600">Active</p>
	                                        <hr />
	                                        <p>Established fact that a reader will be distracted <i class="icofont icofont-emo-heart-eyes font-danger f-20"></i><i class="icofont icofont-emo-heart-eyes font-danger f-20 m-l-5"></i></p>
	                                        <hr />
	                                        <p>Dolore magna aliqua <i class="icofont icofont-emo-rolling-eyes font-success f-20"></i></p>
	                                    </div>
	                                </div>
	                                <div class="tab-pane fade" id="info-contact" role="tabpanel" aria-labelledby="contact-info-tab">
	                                    <div class="user-profile">
	                                        <div class="image">
	                                            <div class="avatar text-center"><img alt="" src="{{asset('assets/images/user/2.png')}}" /></div>
	                                            <div class="icon-wrapper"><i class="icofont icofont-pencil-alt-5"></i></div>
	                                        </div>
	                                        <div class="user-content text-center">
	                                            <h5 class="text-uppercase">mark jenco</h5>
	                                            <div class="social-list">
	                                                <ul>
	                                                    <li>
	                                                        <a href="javascript:void(0)"><i class="fa fa-facebook"></i></a>
	                                                    </li>
	                                                    <li>
	                                                        <a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a>
	                                                    </li>
	                                                    <li>
	                                                        <a href="javascript:void(0)"><i class="fa fa-twitter"></i></a>
	                                                    </li>
	                                                    <li>
	                                                        <a href="javascript:void(0)"><i class="fa fa-instagram"></i></a>
	                                                    </li>
	                                                    <li>
	                                                        <a href="javascript:void(0)"><i class="fa fa-rss"> </i></a>
	                                                    </li>
	                                                </ul>
	                                            </div>
	                                            <div class="follow text-center">
	                                                <div class="row">
	                                                    <div class="col border-right">
	                                                        <span>Following</span>
	                                                        <div class="follow-num">236k</div>
	                                                    </div>
	                                                    <div class="col">
	                                                        <span>Follower</span>
	                                                        <div class="follow-num">3691k</div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="text-center digits">
	                                                <p>Mark.jecno23@gmail.com</p>
	                                                <p>+91 365 - 658 - 1236</p>
	                                                <p>Fax: 123-4560</p>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div> --}}
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	
	@push('scripts')
	@livewireScripts
	<script src="{{asset('assets/js/fullscreen.js')}}"></script>

	<script>
		function scrollDown() {
			document.getElementById('chat').scrollTop = document.getElementById('chat').scrollHeight
		}

		setInterval(scrollDown, 1000);
	</script>
	@endpush

@endsection