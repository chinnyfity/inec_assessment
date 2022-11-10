@include('header')


  <div class="alert alert_msg"></div>

  <div class="main-banner banner_up1">
    <div id="rev_slider_34_1_wrapper" class="rev_slider_wrapper" data-alias="news-gallery34">
      <div id="rev_slider_34_1" class="rev_slider" data-version="5.0.7">
        <ul>
          <li data-index="rs-129"  >
            <img src="{{ asset('images/banner/slider2.jpg') }}"  alt=""  class="rev-slidebg" >
            <div class="tp-caption Newspaper-Title tp-resizeme "
            id="slide-129-layer-1"
            data-x="['left','left','left','left']" data-hoffset="['20','50','50','10']"
            data-y="['top','200','150','center']" data-voffset="['190','135','50','10']"
            data-fontsize="['50','50','50','30']"
            data-lineheight="['55','55','55','35']"
            data-width="['600','600','600','458']"
            data-height="none"
            data-whitespace="normal"
            data-transform_idle="o:1;"
            data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
            data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
            data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
            data-mask_out="x:0;y:0;s:inherit;e:inherit;"
            data-start="1000"
            data-splitin="none"
            data-splitout="none"
            data-responsive_offset="on" >

            <div class="banner-text mt--130 mt-xs-0">
                <h2>Result Analysis</h2>
            </div>
            </div>
          </li>
        </ul>


        <div class="tp-bannertimer tp-bottom"></div>
      </div>
    </div>
  </div>

	<ul id="country_list_id"></ul>

  <div class="gray-bg1 mt-xs--20_ pt-15 pb-15 count_bg">
    <div class="container_ pl-30 pr-30 pl-md-30 pl-xs-20 pr-xs-10">
      <div class="row">

        <div class="col-lg-9 pl-0" style="backgrounds: red">
          <div class="pl-20_ count_items">
            <div>Home - Result Analysis</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section-bar pt-20 mt-xs-20">
    <div class="container pl-20 pr-20">
        <div class="pb-60 pb-xs-30">
            <div class="row">
                <div class="col-lg-8 col-sm-12 pl-xs-5 pr-xs-5">
                    <div class="cards">
                        <div class="body mt-10">
                            <div class="text-left featured_sel mt-xs-15 mb-xs-5">
                                <form autocomplete="off" class="results">
                                    <select class="state">
                                        <option value='' data-value1=''>-Select State-</option>
                                        @if(count($states) > 0)
                                            @foreach($states as $state)
                                                @php
                                                    $state_id = $state['state_id'];
                                                    $state_name = $state['state_name'];
                                                @endphp
                                                <option value="{{ $state_id }}" data-value1="{{ $state_name }}">{{ $state_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    <select class="lga" style="display:none">
                                        <option value='' data-value1=''>Select LGA</option>
                                    </select>

                                    <button type="button" class="btns search_result" style="display:none">Search</button>
                                </form>
                            </div>

                            <div class="text-left mt-30 mb-xs-5">
                                <div class="card card-details">
                                    <div class="infos pt-20 pb-20">Select state and LGA to display result here</div>
                                    <!-- <p><b>State:</b> Delta State</p>
                                    <p><b>LGA:</b> Delta State</p>
                                    <p><b>Total Polling Units:</b> <font>290</font></p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
		
		
      
@include('footer')