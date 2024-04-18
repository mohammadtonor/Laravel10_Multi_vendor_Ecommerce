@extends('frontend.layouts.master')

@section('content')
    
<!--==========================
      PRODUCT MODAL VIEW START
===========================-->
@include('frontend.home.sections.productModalView')
<!--==========================
    PRODUCT MODAL VIEW END
===========================-->


<!--============================
    BANNER PART 2 START
==============================-->
@include('frontend.home.sections.bannerSlider')
<!--============================
    BANNER PART 2 END
==============================-->


<!--============================
    FLASH SELL START
==============================-->
@include('frontend.home.sections.flashsales')
<!--============================
    FLASH SELL END
==============================-->


<!--============================
    MONTHLY TOP PRODUCT START
==============================-->
@include('frontend.home.sections.topProducts')
<!--============================
    MONTHLY TOP PRODUCT END
    ==============================-->
    
    
<!--============================
    BRAND SLIDER START
==============================-->
        
@include('frontend.home.sections.bannerSliderStart')
<!--============================
    BRAND SLIDER END
==============================-->


<!--============================
    SINGLE BANNER START
==============================-->
@include('frontend.home.sections.singleBanner')

<!--============================
    SINGLE BANNER END  
==============================-->


<!--============================
    HOT DEALS START
==============================-->
@include('frontend.home.sections.hotDeals')
<!--============================
    HOT DEALS END  
==============================-->


<!--============================
    ELECTRONIC PART START  
==============================-->
@include('frontend.home.sections.electronicPart')
<!--============================
    ELECTRONIC PART END  
==============================-->


<!--============================
    ELECTRONIC PART START  
==============================-->
@include('frontend.home.sections.electronicPartStart')
<!--============================
    ELECTRONIC PART END  
==============================-->


<!--============================
    LARGE BANNER  START  
==============================-->
@include('frontend.home.sections.largeBanner')
<!--============================
    LARGE BANNER  END  
==============================-->


<!--============================
    WEEKLY BEST ITEM START  
==============================-->
@include('frontend.home.sections.weeklyBestItem')

<!--============================
    WEEKLY BEST ITEM END 
==============================-->


<!--============================
    HOME SERVICES START
==============================-->
@include('frontend.home.sections.homeServices')
<!--============================
    HOME SERVICES END
==============================-->


<!--============================
    HOME BLOGS START
==============================-->
@include('frontend.home.sections.homeBlogsStart')

<!--============================
        HOME BLOGS END
 ==============================-->

@endsection