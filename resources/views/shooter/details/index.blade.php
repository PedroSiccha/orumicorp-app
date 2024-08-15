@extends('layouts.app')
@section('title')
    Administrar Shoter
@endsection
@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="file-manager">
                    <h5>Ver Carpetas:</h5>
                    <a href="#" class="file-control active">Categoria 1</a>
                    <a href="#" class="file-control">Categoria 2</a>
                    <div class="hr-line-dashed"></div>
                    <button class="btn btn-primary btn-block">Crear Carpeta</button>
                    <div class="hr-line-dashed"></div>
                    <h5>Carpetas</h5>
                    <ul class="folder-list" style="padding: 0">
                        <li><a href=""><i class="fa fa-folder"></i> Cliente 01</a></li>
                        <li><a href=""><i class="fa fa-folder"></i> Cliente 02</a></li>
                        <li><a href=""><i class="fa fa-folder"></i> Basura</a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
        <div class="ibox">
            <div class="ibox-content">
                {{-- <span class="text-muted small float-right">Ultima Actualización: <i class="fa fa-clock-o"></i> 2:10 pm - 12/06/2024</span> --}}
                <h2>Clientes</h2>
                {{-- <div class="input-group">
                    <input type="text" placeholder="Buscar cliente " class="input form-control">
                    <span class="input-group-append">
                            <button type="button" class="btn btn btn-primary"> <i class="fa fa-search"></i> Buscar</button>
                    </span>
                </div> --}}
                <div class="clients-list">
                {{-- <span class="float-right small text-muted">14 Clientes</span> --}}
                <ul class="nav nav-tabs">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Campaña 01</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"><i class="fa fa-briefcase"></i> Campaña 02</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td class="client-avatar"><img alt="image" src="img/a2.jpg"> </td>
                                        <td><a href="#contact-1" class="client-link">Anthony Jackson</a></td>
                                        <td> Tellus Institute</td>
                                        <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                        <td> gravida@rbisit.com</td>
                                        <td class="client-status"><span class="label label-primary">Active</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 366.599px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td><a href="#company-1" class="client-link">Tellus Institute</a></td>
                                        <td>Rexton</td>
                                        <td><i class="fa fa-flag"></i> Angola</td>
                                        {{-- <td class="client-status"><span class="label label-primary">Active</span></td> --}}
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="ibox selected">

            <div class="ibox-content">
                <div class="tab-content">
                    <div id="contact-1" class="tab-pane active">
                        <div class="row m-b-lg">
                            <div class="col-lg-4 text-center">
                                <h2>Nicki Smith</h2>

                                <div class="m-b-sm">
                                    <img alt="image" class="rounded-circle" src="img/a2.jpg" style="width: 62px">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <strong>
                                    About me
                                </strong>

                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                                <button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message
                                </button>
                            </div>
                        </div>
                        <div class="client-detail">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

                            <strong>Last activity</strong>

                            <ul class="list-group clear-list">
                                <li class="list-group-item fist-item">
                                    <span class="float-right"> 09:00 pm </span>
                                    Please contact me
                                </li>
                                <li class="list-group-item">
                                    <span class="float-right"> 10:16 am </span>
                                    Sign a contract
                                </li>
                                <li class="list-group-item">
                                    <span class="float-right"> 08:22 pm </span>
                                    Open new shop
                                </li>
                                <li class="list-group-item">
                                    <span class="float-right"> 11:06 pm </span>
                                    Call back to Sylvia
                                </li>
                                <li class="list-group-item">
                                    <span class="float-right"> 12:00 am </span>
                                    Write a letter to Sandra
                                </li>
                            </ul>
                            <strong>Notes</strong>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <hr>
                            <strong>Timeline activity</strong>
                            <div id="vertical-timeline" class="vertical-container dark-timeline">
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon gray-bg">
                                        <i class="fa fa-coffee"></i>
                                    </div>
                                    <div class="vertical-timeline-content">
                                        <p>Conference on the sales results for the previous year.
                                        </p>
                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                    </div>
                                </div>
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon gray-bg">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="vertical-timeline-content">
                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                        </p>
                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                    </div>
                                </div>
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon gray-bg">
                                        <i class="fa fa-bolt"></i>
                                    </div>
                                    <div class="vertical-timeline-content">
                                        <p>There are many variations of passages of Lorem Ipsum available.
                                        </p>
                                        <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                    </div>
                                </div>
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon navy-bg">
                                        <i class="fa fa-warning"></i>
                                    </div>
                                    <div class="vertical-timeline-content">
                                        <p>The generated Lorem Ipsum is therefore.
                                        </p>
                                        <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                    </div>
                                </div>
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon gray-bg">
                                        <i class="fa fa-coffee"></i>
                                    </div>
                                    <div class="vertical-timeline-content">
                                        <p>Conference on the sales results for the previous year.
                                        </p>
                                        <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                    </div>
                                </div>
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon gray-bg">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="vertical-timeline-content">
                                        <p>Many desktop publishing packages and web page editors now use Lorem.
                                        </p>
                                        <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                    </div>
                                </div>
                            </div>
                        </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 405.913px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                    <div id="contact-2" class="tab-pane">
                        <div class="row m-b-lg">
                            <div class="col-lg-4 text-center">
                                <h2>Edan Randall</h2>

                                <div class="m-b-sm">
                                    <img alt="image" class="rounded-circle" src="img/a3.jpg" style="width: 62px">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <strong>
                                    About me
                                </strong>

                                <p>
                                    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default tempor incididunt model text.
                                </p>
                                <button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message
                                </button>
                            </div>
                        </div>
                        <div class="client-detail">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

                                <strong>Last activity</strong>

                                <ul class="list-group clear-list">
                                    <li class="list-group-item fist-item">
                                        <span class="float-right"> 09:00 pm </span>
                                        Lorem Ipsum available
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 10:16 am </span>
                                        Latin words, combined
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 08:22 pm </span>
                                        Open new shop
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 11:06 pm </span>
                                        The generated Lorem Ipsum
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 12:00 am </span>
                                        Content here, content here
                                    </li>
                                </ul>
                                <strong>Notes</strong>
                                <p>
                                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.
                                </p>
                                <hr>
                                <strong>Timeline activity</strong>
                                <div id="vertical-timeline" class="vertical-container dark-timeline">
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-bolt"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>There are many variations of passages of Lorem Ipsum available.
                                            </p>
                                            <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-warning"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>The generated Lorem Ipsum is therefore.
                                            </p>
                                            <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                    <div id="contact-3" class="tab-pane">
                        <div class="row m-b-lg">
                            <div class="col-lg-4 text-center">
                                <h2>Jasper Carson</h2>

                                <div class="m-b-sm">
                                    <img alt="image" class="rounded-circle" src="img/a4.jpg" style="width: 62px">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <strong>
                                    About me
                                </strong>

                                <p>
                                    Latin professor at Hampden-Sydney College in Virginia, looked  embarrassing hidden in the middle.
                                </p>
                                <button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message
                                </button>
                            </div>
                        </div>
                        <div class="client-detail">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

                                <strong>Last activity</strong>

                                <ul class="list-group clear-list">
                                    <li class="list-group-item fist-item">
                                        <span class="float-right"> 09:00 pm </span>
                                        Aldus PageMaker including
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 10:16 am </span>
                                        Finibus Bonorum et Malorum
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 08:22 pm </span>
                                        Write a letter to Sandra
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 11:06 pm </span>
                                        Standard chunk of Lorem
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 12:00 am </span>
                                        Open new shop
                                    </li>
                                </ul>
                                <strong>Notes</strong>
                                <p>
                                    Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.
                                </p>
                                <hr>
                                <strong>Timeline activity</strong>
                                <div id="vertical-timeline" class="vertical-container dark-timeline">
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-bolt"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>There are many variations of passages of Lorem Ipsum available.
                                            </p>
                                            <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-warning"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>The generated Lorem Ipsum is therefore.
                                            </p>
                                            <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                    <div id="contact-4" class="tab-pane">
                        <div class="row m-b-lg">
                            <div class="col-lg-4 text-center">
                                <h2>Reuben Pacheco</h2>

                                <div class="m-b-sm">
                                    <img alt="image" class="rounded-circle" src="img/a5.jpg" style="width: 62px">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <strong>
                                    About me
                                </strong>

                                <p>
                                    Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero,written in 45 BC. This book is a treatise on.
                                </p>
                                <button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message
                                </button>
                            </div>
                        </div>
                        <div class="client-detail">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

                                <strong>Last activity</strong>

                                <ul class="list-group clear-list">
                                    <li class="list-group-item fist-item">
                                        <span class="float-right"> 09:00 pm </span>
                                        The point of using
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 10:16 am </span>
                                        Lorem Ipsum is that it has
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 08:22 pm </span>
                                        Text, and a search for 'lorem ipsum'
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 11:06 pm </span>
                                        Passages of Lorem Ipsum
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> 12:00 am </span>
                                        If you are going
                                    </li>
                                </ul>
                                <strong>Notes</strong>
                                <p>
                                    Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                </p>
                                <hr>
                                <strong>Timeline activity</strong>
                                <div id="vertical-timeline" class="vertical-container dark-timeline">
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-bolt"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>There are many variations of passages of Lorem Ipsum available.
                                            </p>
                                            <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-warning"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>The generated Lorem Ipsum is therefore.
                                            </p>
                                            <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                    <div id="company-1" class="tab-pane">
                        <div class="m-b-lg">
                                <h2>Tellus Institute</h2>

                                <p>
                                    Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero,written in 45 BC. This book is a treatise on.
                                </p>
                                <div>
                                    <small>Active project completion with: 48%</small>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </div>
                        </div>
                        <div class="client-detail">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

                                <strong>Last activity</strong>

                                <ul class="list-group clear-list">
                                    <li class="list-group-item fist-item">
                                        <span class="float-right"> <span class="label label-primary">NEW</span> </span>
                                        The point of using
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> <span class="label label-warning">WAITING</span></span>
                                        Lorem Ipsum is that it has
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> <span class="label label-danger">BLOCKED</span> </span>
                                        If you are going
                                    </li>
                                </ul>
                                <strong>Notes</strong>
                                <p>
                                    Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                </p>
                                <hr>
                                <strong>Timeline activity</strong>
                                <div id="vertical-timeline" class="vertical-container dark-timeline">
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-bolt"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>There are many variations of passages of Lorem Ipsum available.
                                            </p>
                                            <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-warning"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>The generated Lorem Ipsum is therefore.
                                            </p>
                                            <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                    <div id="company-2" class="tab-pane">
                        <div class="m-b-lg">
                            <h2>Penatibus Consulting</h2>

                            <p>
                                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some.
                            </p>
                            <div>
                                <small>Active project completion with: 22%</small>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="client-detail">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

                                <strong>Last activity</strong>

                                <ul class="list-group clear-list">
                                    <li class="list-group-item fist-item">
                                        <span class="float-right"> <span class="label label-warning">WAITING</span> </span>
                                        Aldus PageMaker
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"><span class="label label-primary">NEW</span> </span>
                                        Lorem Ipsum, you need to be sure
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"> <span class="label label-danger">BLOCKED</span> </span>
                                        The generated Lorem Ipsum
                                    </li>
                                </ul>
                                <strong>Notes</strong>
                                <p>
                                    Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                </p>
                                <hr>
                                <strong>Timeline activity</strong>
                                <div id="vertical-timeline" class="vertical-container dark-timeline">
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-bolt"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>There are many variations of passages of Lorem Ipsum available.
                                            </p>
                                            <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-warning"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>The generated Lorem Ipsum is therefore.
                                            </p>
                                            <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                    <div id="company-3" class="tab-pane">
                        <div class="m-b-lg">
                            <h2>Ultrices Incorporated</h2>

                            <p>
                                Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.
                            </p>
                            <div>
                                <small>Active project completion with: 72%</small>
                                <div class="progress progress-mini">
                                    <div style="width: 72%;" class="progress-bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="client-detail">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;"><div class="full-height-scroll" style="overflow: hidden; width: auto; height: 100%;">

                                <strong>Last activity</strong>

                                <ul class="list-group clear-list">
                                    <li class="list-group-item fist-item">
                                        <span class="float-right"> <span class="label label-danger">BLOCKED</span> </span>
                                        Hidden in the middle of text
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right"><span class="label label-primary">NEW</span> </span>
                                        Non-characteristic words etc.
                                    </li>
                                    <li class="list-group-item">
                                        <span class="float-right">  <span class="label label-warning">WAITING</span> </span>
                                        Bonorum et Malorum
                                    </li>
                                </ul>
                                <strong>Notes</strong>
                                <p>
                                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.
                                </p>
                                <hr>
                                <strong>Timeline activity</strong>
                                <div id="vertical-timeline" class="vertical-container dark-timeline">
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-bolt"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>There are many variations of passages of Lorem Ipsum available.
                                            </p>
                                            <span class="vertical-date small text-muted"> 06:10 pm - 11.03.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg">
                                            <i class="fa fa-warning"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>The generated Lorem Ipsum is therefore.
                                            </p>
                                            <span class="vertical-date small text-muted"> 02:50 pm - 03.10.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-coffee"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Conference on the sales results for the previous year.
                                            </p>
                                            <span class="vertical-date small text-muted"> 2:10 pm - 12.06.2014 </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon gray-bg">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <p>Many desktop publishing packages and web page editors now use Lorem.
                                            </p>
                                            <span class="vertical-date small text-muted"> 4:20 pm - 10.05.2014 </span>
                                        </div>
                                    </div>
                                </div>
                            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
