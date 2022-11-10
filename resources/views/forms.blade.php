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

            <div class="banner-text mt--80 mt-xs-0">
                <h2>Enter Results</h2>
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
            <div>Home - Enter Result</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section-bar pt-20 mt-xs-20">
    <div class="container pl-20 pr-20">
        <div class="pb-60 pb-xs-30">
            <div class="row">
                <div class="col-lg-7 col-sm-12 pl-xs-5 pr-xs-5 first_form">
                    <div class="cards">
                        <div class="body mt-10">
                            <form class="input-groups form_score" id="" autocomplete="off">
                                {{ csrf_field() }}
                                
                                <div style="font-size: 14px; color: red">All the fields here are compulsory</div>

                                <div class="row mt-30 mt-xs-15">
                                    <div class="col-md-3">
                                        <label>Select State</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name="state">
                                            <option value=''>-Select State-</option>
                                            @if(count($states) > 0)
                                                @foreach($states as $state)
                                                    @php
                                                        $state_id = $state['state_id'];
                                                        $state_name = $state['state_name'];
                                                    @endphp
                                                    <option value="{{ $state_id }}" >{{ $state_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Select Party</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" name="party">
                                            <option value=''>-Select Party-</option>
                                            @if(count($parties) > 0)
                                                @foreach($parties as $party)
                                                    @php
                                                        $party_id = $party['partyid'];
                                                        $party_name = $party['partyname'];
                                                    @endphp
                                                    <option value="{{ $party_id }}" >{{ $party_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Polling Unit</label>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <select class="form-control" name="unit">
                                            <option value=''>-Select Unit-</option>
                                            @if(count($polling_units) > 0)
                                                @foreach($polling_units as $polling_unit)
                                                    @php
                                                        $unit_id = $polling_unit['polling_unit_id'];
                                                        $unit_name = $polling_unit['polling_unit_name'];
                                                    @endphp

                                                    @if($unit_name != "")
                                                        <option value="{{ $unit_id }}" >{{ ucwords($unit_name) }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-2 pl-2">
                                        <button type="button" class="btn add_unit">ADD UNIT</button>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Enter Score</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="score" class="form-control" placeholder="Enter the score" style="text-transform: capitalize;" value="">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Enter Your Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control" placeholder="Enter your names" style="text-transform: capitalize;" value="">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="offset-md-3 col-md-8 mt-15">
                                    <button type="button" class="btn btn-block btn-success m-t-15 waves-effect waves-light enter_score">ENTER SCORE</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-sm-4 p-xs-0 img_1 d-lg-block d-md-none">
                    <img src="{{ asset('images/inec.jpg') }}">
                </div>
            </div>
        </div>
    </div>
  </div>
		
		
      
@include('footer')