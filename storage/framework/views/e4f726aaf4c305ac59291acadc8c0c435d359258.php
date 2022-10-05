<?php
  $listLocation = (new \App\Brand)->listLocation();
  $locations = \App\Brand::where('status', 1)->get();
  if($locations)
    $locations = json_encode($locations, JSON_UNESCAPED_UNICODE);
?>
<div class="page-agents">
   <div class="row">
      <div class="col-lg-6">
         <?php if($listLocation): ?>
         <?php $i = 0; ?>
         <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php $__currentLoopData = $listLocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <li class="nav-item">
                  <a class="nav-link <?php echo e($i==0 ? 'active' : ''); ?>" id="<?php echo e($key); ?>-tab" data-toggle="tab" href="#<?php echo e($key); ?>" role="tab" aria-controls="<?php echo e($key); ?>" aria-selected="true"><?php echo e($item); ?></a>
               </li>
               <?php $i++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </ul>
         <div class="tab-content" id="myTabContent">
            <?php $i = 0; ?>
            <?php $__currentLoopData = $listLocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                  $agents = \App\Brand::where('location', $key)->where('status', 1)->get();
               ?>
               <div class="tab-pane fade <?php echo e($i==0 ? 'show active' : ''); ?>" id="<?php echo e($key); ?>" role="tabpanel" aria-labelledby="<?php echo e($key); ?>-tab">
                  <div class="scroll-custom">
                     <div class="list-group list-group-flush ">
                        <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($agent->link!='' ? $agent->link : 'javascript:;'); ?>" target="<?php echo e($agent->link!='' ? '_blank' : ''); ?>" class="list-group-item list-group-item-action flex-column align-items-start location-item">
                            <div class="d-flex w-100 justify-content-between">
                              <h5 class="mb-2 title"><?php echo e($agent->name); ?></h5>
                            </div>
                            <?php if($agent->phone): ?>
                              <div class="fone_partner"><i class="fa fa-phone"></i> <span><?php echo e($agent->phone); ?></span></div>
                              <?php endif; ?>
                              <?php if($agent->email): ?>
                              <div class="email_partner"><i class="fa fa-envelope-o"></i> <span><?php echo e($agent->email); ?></span></div>
                              <?php endif; ?>
                              <?php if($agent->address): ?>
                              <div class="address_partner mb-0"><i class="fa fa-map-marker"></i> <span><?php echo e($agent->address); ?></span></div>
                              <?php endif; ?>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </div>
                  </div>
               </div>
               <?php $i++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
         <?php endif; ?>
      </div>

      <div class="col-lg-6">
         <div id="location-maps" class="map_api">
                <div id="map" class="map_api clear"></div>
            </div>
      </div>

   </div>
</div>

<?php $__env->startPush('after-footer'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-eCEI4wiuaWtUAmSDRZQKYs2roDEBirY"></script>
<script type="text/javascript" src="<?php echo e(asset($templateFile .'/js/jquery.slimscroll.js')); ?>"></script>

<style>
   #map{
      height: 450px;
   }
    .header-bottom{
        position: relative;
        background: #12505bcc;
    }
    .info_content_map p{
        font-size: 13px;
    }
</style>

<script type="text/javascript">
    var locations = <?php echo $locations; ?>;
    var lst = '';
    //var provinces =[];
    function getTitle(title, address,fone,email) {
        var contentString = '<div class="info" style="min-width: 250px"><div class="info_content_map">';
        contentString += '<h4 style="font-size: 18px; line-height: 25px; font-weight: bold; color: #02282a; margin: 0 0px 5px 0px;"> ' + title + ' </h4>';
        if(fone)
         contentString += '<p style="font-size: 13px; margin-bottom: 5px;"><i class="fa fa-phone"></i> <b>' + fone + '</b></p>';
       if(email)
           contentString += '<p style="font-size: 13px; margin-bottom: 5px;"><i class="fa fa-envelope-o"></i> <b>' + email + '</b></p>';
       if(address)
         contentString += '<div style="font-size: 13px; margin-bottom: 0;"><i class="fa fa-map-marker"></i> ' + address + '</div>';
        contentString += '</div></div>';
        return contentString;
    }
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        getAll();
        $("#list-location-group").slimScroll({
            size: '5px',
            color: '#0f66a0',
            height:'450px',
            allowPageScroll: true,
            alwaysVisible: true
        });
    });
    //  function initialize() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        scrollwheel: false,
        panControl: true,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE
        },
        scaleControl: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var bounds = new google.maps.LatLngBounds();
    var marker, i;
    var markers = [];
    var geocoder = new google.maps.Geocoder();
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    function getAll() {
        // Loop through our array of markers & place each one on the map
        // for (i = 0; i < locations.length; i++) {
        $.each(locations, function(index, item) {
            var position = new google.maps.LatLng(item.addr_lat, item.addr_long);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: item.name
            });
            // Allow each marker to have an info window
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(getTitle(item.name, item.address, item.email, item.phone));
                    infoWindow.open(map, marker);
                }
            })(marker, i));
            markers.push(marker);
            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        });
        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            //this.setZoom(14);
            google.maps.event.removeListener(boundsListener);
        });
    }


    // function showAddress(id) {
    $('.location-item').click(function(){
        resetMap();
        var address_cus = $(this).find('.address_partner span').text();
        var fone_cus = $(this).find('.fone_partner span').text();
        var email_cus = $(this).find('.email_partner span').text();
        var title_cus = $(this).find('.title').text();
        $('.location-item').removeClass('active');
        $(this).addClass('active');
        geocoder.geocode({
            'address': address_cus
        }, function (results, status) {
            console.log(results);
            if (status == google.maps.GeocoderStatus.OK) {

                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    title: address_cus,
                    position: results[0].geometry.location
                });
                markers.push(marker);
                bounds.extend(marker.getPosition());
                map.fitBounds(bounds);


                infoWindow.setContent(getTitle(title_cus, address_cus,fone_cus,email_cus));
                infoWindow.open(map, marker);

                google.maps.event.addListener(marker, 'dblclick', function () {
                    //window.location.href = this.url;
                });

                google.maps.event.addListener(marker, 'click', (function (marker, location) {
                    return function () {
                        infoWindow.setContent(getTitle(title_cus, address_cus,fone_cus,email_cus));
                        infoWindow.open(map, marker);
                    };
                })(marker, address_cus));
                map.setCenter(results[0].geometry.location);
                map.setZoom(15);

            } else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                setTimeout(function () {
                }, 20);
            } else if (status === google.maps.GeocoderStatus.ZERO_RESULTS) {
            }

            else {
                alert("Geocode was not successful for the following reason:"
                    + status);
            }
        });
    })
    function resetMap() {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/page/agent-content-tabs.blade.php ENDPATH**/ ?>