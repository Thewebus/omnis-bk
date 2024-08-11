@extends('layouts.personnel.master')

@section('title')Bookmarks
 {{ $title }}
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.css')}}">
@endpush

@section('content')
	@component('components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Profile</h3>
		@endslot
		{{-- <li class="breadcrumb-item">Apps</li> --}}
		<li class="breadcrumb-item active">Profile</li>
	@endcomponent

	<div class="container-fluid">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                <div class="col-xl-3">
                    <div class="email-sidebar"><a class="btn btn-primary email-aside-toggle" href="javascript:void(0)">bookmark filter</a>
                        <div class="email-left-aside">
                            <div class="card">
                                <div class="card-body">
                                <div class="email-app-sidebar left-bookmark">
                                    <div class="media">
                                    <div class="media-size-email"><img class="me-3 rounded-circle" src="{{asset('assets/images/user/user.png')}}" alt=""></div>
                                    <div class="media-body">
                                        <h6 class="f-w-600">{{ Auth::user()->fullname }}</h6>
                                        <p>{{ Auth::user()->email }}</p>
                                    </div>
                                    </div>
                                    <ul class="nav main-menu" role="tablist">
                                    <li class="nav-item">
                                    <li><a class="badge-light btn-block btn-mail" id="pills-informations-tab" data-bs-toggle="pill" href="#pills-informations" role="tab" aria-controls="pills-informations" aria-selected="true"><span class="title"> Informations </span></a></li>
                                    </li>
                                    <li class="nav-item"><span class="main-title"> Views</span></li>
                                    <li><a class="show" id="pills-created-tab" data-bs-toggle="pill" href="#pills-created" role="tab" aria-controls="pills-created" aria-selected="false"><span class="title"> Created by me</span></a></li>
                                    <li><a class="show" id="pills-favourites-tab" data-bs-toggle="pill" href="#pills-favourites" role="tab" aria-controls="pills-favourites" aria-selected="false"><span class="title"> Favourites</span></a></li>
                                    <li><a class="show" id="pills-shared-tab" data-bs-toggle="pill" href="#pills-shared" role="tab" aria-controls="pills-shared" aria-selected="false"><span class="title"> Shared with me</span></a></li>
                                    <li><a class="show" id="pills-bookmark-tab" data-bs-toggle="pill" href="#pills-bookmark" role="tab" aria-controls="pills-bookmark" aria-selected="false"><span class="title"> My bookmark</span></a></li>
                                    <li>
                                        <hr>
                                    </li>
                                    <li><span class="main-title"> Tags<span class="pull-right"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createtag"><i data-feather="plus-circle"></i></a></span></span></li>
                                    <li><a class="show" id="pills-notification-tab" data-bs-toggle="pill" href="#pills-notification" role="tab" aria-controls="pills-notification" aria-selected="false"><span class="title"> Notification</span></a></li>
                                    <li><a class="show" id="pills-newsletter-tab" data-bs-toggle="pill" href="#pills-newsletter" role="tab" aria-controls="pills-newsletter" aria-selected="false"><span class="title"> Newsletter</span></a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-12 box-col-8">
                    <div class="email-right-aside bookmark-tabcontent">
                        <div class="card email-body radius-left">
                            <div class="ps-0">
                                <div class="tab-content">

                                    <div class="fade tab-pane active show" id="pills-informations" role="tabpanel" aria-labelledby="pills-informations-tab">
                                        <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">informations</h6>
                                            <ul>
                                            <li><a class="grid-bookmark-view" href="javascript:void(0)"><i data-feather="grid"></i></a></li>
                                            <li><a class="list-layout-view" href="javascript:void(0)"><i data-feather="list"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="details-bookmark">
                                                <form>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="numero">Nom & Prenom</label>
                                                            <input class="form-control" value="{{ Auth::user()->fullname }}" type="text" disabled/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="parent">Email</label>
                                                            <input class="form-control" value="{{ Auth::user()->email }}" type="text" disabled/>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="numero">Contact Cel</label>
                                                            <input class="form-control" @isset(Auth::user()->numero) value="{{ Auth::user()->numero }}" @endisset type="text" disabled/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="parent">Numéro parent</label>
                                                            <input class="form-control" @isset(Auth::user()->parent) value="{{ Auth::user()->parent }}" @endisset type="text" disabled/>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="fixe">Numéro fixe</label>
                                                            <input class="form-control" @isset(Auth::user()->fixe) value="{{ Auth::user()->fixe }}" @endisset type="text" disabled/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="postale">Adresse Postale</label>
                                                            <input class="form-control" @isset(Auth::user()->postale) value="{{ Auth::user()->postale }}" @endisset type="text" disabled/>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label" for="filiere">Filière</label>
                                                            <input class="form-control" @isset(Auth::user()->filiere->nom) value="{{ Auth::user()->filiere->nom }}" @endisset  type="text" disabled/>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label" for="filiere">Cursus</label>
                                                            <input class="form-control" @isset(Auth::user()->cursus) value="{{ Auth::user()->cursus }}" @endisset  type="text" disabled/>
                                                        </div>
                                                    </div>
                                                </form>
                                                @if (Auth::user()->cursus)
                                                    <a href="{{ route('recepice') }}" class="btn btn-primary" type="submit"><i class="icon-import"></i> Télécharger le recepicé</a>
                                                @else
                                                    <button class="btn btn-primary disabled" type="submit"><i class="icon-import"></i> Télécharger le recepicé</button>
                                                @endif
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-created" role="tabpanel" aria-labelledby="pills-created-tab">
                                        <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Created by me</h6>
                                            <ul>
                                            <li><a class="grid-bookmark-view" href="javascript:void(0)"><i data-feather="grid"></i></a></li>
                                            <li><a class="list-layout-view" href="javascript:void(0)"><i data-feather="list"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body pb-0">
                                            <div class="details-bookmark text-center">
                                            <div class="row" id="bookmarkData">
                                                <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 xl-50 box-col-6">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/01.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_0" onclick="setFavourite(0)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_0">Admin Template</h6>
                                                        <p class="weburl_0">http://admin.pixelstrap.com/endless/ltr/landing-page.html</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(0)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_0">Endless is beautifully crafted, clean and modern designed admin theme with 6 different demos and light - dark versions.</p><span class="collection_0">General</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 xl-50 box-col-6">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/02.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_1" onclick="setFavourite(1)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_1">Universal Template</h6>
                                                        <p class="weburl_1">https://angular.pixelstrap.com/universal/landing</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(1)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_1">Universal is beautifully crafted, clean and modern designed admin theme</p><span class="collection_1">General</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 xl-50 box-col-6">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/03.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_2" onclick="setFavourite(2)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_2">Angular Theme</h6>
                                                        <p class="weburl_2">https://angular.pixelstrap.com/endless/landing</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(2)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_2">Endless is beautifully crafted, clean and modern designed admin theme</p><span class="collection_2">Fs</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 xl-50 box-col-6">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/04.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_3" onclick="setFavourite(3)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_3">Multikart Admin</h6>
                                                        <p class="weburl_3">http://themes.pixelstrap.com/multikart/back-end/index.html</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(3)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_3">Multikart Admin is modern designed admin theme</p><span class="collection_3">General</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 xl-50 box-col-6">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/05.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_4" onclick="setFavourite(4)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_4">Ecommerece theme</h6>
                                                        <p class="weburl_4">http://themes.pixelstrap.com/multikart</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(4)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_4">Multikart HTML template is an apparently simple but highly functional tempalate designed for creating a flourisahing online business.</p><span class="collection_4">General           </span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 xl-50 box-col-6">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/06.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_5" onclick="setFavourite(5)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_5">Tovo app landing page</h6>
                                                        <p class="weburl_5">http://vue.pixelstrap.com/tovo/home-one</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(5)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_5">Amazing Landing Page With Easy Customization</p><span class="collection_5">Fs                      </span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="fade tab-pane" id="pills-favourites" role="tabpanel" aria-labelledby="pills-favourites-tab">
                                        <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Favourites</h6>
                                            <ul>
                                            <li><a class="grid-bookmark-view" href="javascript:void(0)"><i data-feather="grid"></i></a></li>
                                            <li><a class="list-layout-view" href="javascript:void(0)"><i data-feather="list"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="details-bookmark text-center">
                                            <div class="row" id="favouriteData"></div>
                                            <div class="no-favourite"><span>No Bookmarks Found.</span></div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="fade tab-pane" id="pills-shared" role="tabpanel" aria-labelledby="pills-shared-tab">
                                        <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Shared with me</h6>
                                            <ul>
                                            <li><a class="grid-bookmark-view" href="javascript:void(0)"><i data-feather="grid"></i></a></li>
                                            <li><a class="list-layout-view" href="javascript:void(0)"><i data-feather="list"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="details-bookmark text-center"><span>No Bookmarks Found.</span></div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="fade tab-pane" id="pills-bookmark" role="tabpanel" aria-labelledby="pills-bookmark-tab">
                                        <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">My bookmark</h6>
                                            <ul>
                                            <li><a class="grid-bookmark-view" href="javascript:void(0)"><i data-feather="grid"></i></a></li>
                                            <li><a class="list-layout-view" href="javascript:void(0)"><i data-feather="list"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="details-bookmark text-center">
                                            <div class="row" id="bookmarkData1">
                                                <div class="col-xl-3 col-md-4 xl-50">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/07.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_0" onclick="setFavourite(0)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_0">Admin Template</h6>
                                                        <p class="weburl_0">http://admin.pixelstrap.com/endless/ltr/landing-page.html</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(0)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_0">Endless is beautifully crafted, clean and modern designed admin theme with 6 different demos and light - dark versions.</p><span class="collection_0">General</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-md-4 xl-50">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/07.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_1" onclick="setFavourite(1)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_1">Universal Template</h6>
                                                        <p class="weburl_1">https://angular.pixelstrap.com/universal/landing</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(1)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_1">Universal is beautifully crafted, clean and modern designed admin theme</p><span class="collection_1">General</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-md-4 xl-50">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/01.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_2" onclick="setFavourite(2)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_2">Angular Theme</h6>
                                                        <p class="weburl_2">https://angular.pixelstrap.com/endless/landing</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(2)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_2">Endless is beautifully crafted, clean and modern designed admin theme</p><span class="collection_2">Fs</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-md-4 xl-50">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/07.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_3" onclick="setFavourite(3)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_3">Multikart Admin</h6>
                                                        <p class="weburl_3">http://themes.pixelstrap.com/multikart/back-end/index.html</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(3)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_3">Multikart Admin is modern designed admin theme</p><span class="collection_3">General</span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-md-4 xl-50">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/07.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_4" onclick="setFavourite(4)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_4">Ecommerece theme</h6>
                                                        <p class="weburl_4">http://themes.pixelstrap.com/multikart</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(4)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_4">Multikart HTML template is an apparently simple but highly functional tempalate designed for creating a flourisahing online business.</p><span class="collection_4">General           </span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-xl-3 col-md-4 xl-50">
                                                <div class="card bookmark-card o-hidden">
                                                    <div class="details-website"><img class="img-fluid" src="{{asset('assets/images/lightgallry/07.jpg')}}" alt="">
                                                    <div class="favourite-icon favourite_5" onclick="setFavourite(5)"><a href="javascript:void(0)"><i class="fa fa-star"></i></a></div>
                                                    <div class="desciption-data">
                                                        <div class="title-bookmark">
                                                        <h6 class="title_5">Tovo app landing page</h6>
                                                        <p class="weburl_5">http://vue.pixelstrap.com/tovo/home-one</p>
                                                        <div class="hover-block">
                                                            <ul>
                                                            <li><a href="" onclick="editBookmark(5)" data-bs-toggle="modal" data-bs-target="#edit-bookmark"><i data-feather="edit-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="link"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="share-2"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i data-feather="trash-2"></i></a></li>
                                                            <li class="pull-right text-end"><a href="javascript:void(0)"><i data-feather="tag"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-general">
                                                            <p class="desc_5">Amazing Landing Page With Easy Customization</p><span class="collection_5">Fs                      </span>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="fade tab-pane" id="pills-notification" role="tabpanel" aria-labelledby="pills-notification-tab">
                                        <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Notification</h6>
                                            <ul>
                                            <li><a class="grid-bookmark-view" href="javascript:void(0)"><i data-feather="grid"></i></a></li>
                                            <li><a class="list-layout-view" href="javascript:void(0)"><i data-feather="list"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="details-bookmark text-center"><span>No Bookmarks Found.</span></div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="fade tab-pane" id="pills-newsletter" role="tabpanel" aria-labelledby="pills-newsletter-tab">
                                        <div class="card mb-0">
                                        <div class="card-header d-flex">
                                            <h6 class="mb-0">Newsletter</h6>
                                            <ul>
                                            <li><a class="grid-bookmark-view" href="javascript:void(0)"><i data-feather="grid"></i></a></li>
                                            <li><a class="list-layout-view" href="javascript:void(0)"><i data-feather="list"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="details-bookmark text-center"><span>No Bookmarks Found.</span></div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="modal fade modal-bookmark" id="edit-bookmark" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title">Edit Bookmark</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form class="form-bookmark needs-validation" novalidate="">
                                                <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Web Url</label>
                                                    <input class="form-control" id="editurl" type="text" required="" autocomplete="off" value="http://admin.pixelstrap.com/endless/ltr/landing-page.html">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Title</label>
                                                    <input class="form-control" id="edittitle" type="text" required="" autocomplete="off" value="Admin Template">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Description</label>
                                                    <textarea class="form-control" id="editdesc" required="" autocomplete="off">Endless is beautifully crafted, clean and modern designed admin theme with 6 different demos and light - dark versions.</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col mb-0">
                                                    <label>Group</label>
                                                    <select class="js-example-basic-single">
                                                        <option value="AL">My Bookmarks</option>
                                                    </select>
                                                    </div>
                                                    <div class="form-group col mb-0">
                                                    <label>Collection</label>
                                                    <select class="js-example-disabled-results">
                                                        <option value="general">General</option>
                                                        <option value="fs">fs</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                </div>
                                                <button class="btn btn-secondary" type="button">Save</button>
                                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel   </button>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="modal fade modal-bookmark" id="createtag" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title">Create Tag</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">                                            </button>
                                            </div>
                                            <div class="modal-body">
                                            <form class="form-bookmark needs-validation" novalidate="">
                                                <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Tag Name</label>
                                                    <input class="form-control" type="text" required="" autocomplete="off">
                                                </div>
                                                <div class="form-group col-md-12 mb-0">
                                                    <label>Tag color</label>
                                                    <input class="form-control fill-color" type="color" value="#563d7c">
                                                </div>
                                                </div>
                                                <button class="btn btn-secondary" type="button">Save</button>
                                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	@push('scripts')
	<script src="{{asset('assets/js/bookmark/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/bookmark/custom.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
    <script src="{{asset('assets/js/form-validation-custom.js')}}"></script>
	@endpush

@endsection
