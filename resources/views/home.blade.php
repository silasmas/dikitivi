@extends('layouts.app')

@section('app-content')

                <!-- Hero Slider start -->
                <div class="hero-slider hero-slider-three">
                    <div class="single-slide-3 d-flex align-items-center bg-image-two bg-grey" data-bgimage="assets/images/slider/background-image-03.jpg">
                        <!-- Hero Content One Start -->
                        <div class="hero-content-three container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slider-text-info">
                                        <h3>WELCOME TO STREAMO</h3>
                                        <h1> Best Streaming</h1>
                                        <p>
                                            Lorem ipsum dolor sit amet, coectetur adipisicing elit, sed do eiusmod
                                            tempor incidiunt ut laqua. Ut enim ad minim veniam, quis nullamco laboris
                                        </p>
                                        <div class="slider-button">
                                            <a href="about.html" class="default-btn mr--10 bg-tow">Learn More</a>
                                            <a href="#Video-one" class="video-play-btn afterglow ml--10">
                                                <i class="zmdi zmdi-play"></i>
                                            </a>

                                            <video id="Video-one" width="960" height="540">
                                                <source src="https://afterglowplayer.com/sandbox/v1/afterglow_local_hd.mp4" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hero Content One End -->
                    </div>
                </div>
                <!-- Hero Slider end -->

@endsection
