<?php
if(!isset($bgimg) || empty($bgimg)){
    $bgimg = '/upload/images/background/parallax-1.jpeg';
}
if(!isset($bg) || empty($bg)){
    $bg = 'dark';
}
switch ($bg) {
    case 'dark':
        $textColor = 'text-white';
        break;
    case 'light':
        $textColor = '';
        break;
    default:
        $textColor = '';
        break;
}

?>
<div class="section">
    <div class="hero hero--large hero__overlay bg-size" style="background-image: url({{ $bgimg }}); background-size: cover; background-position: left top; background-repeat: no-repeat; background-attachment: fixed;">
        <img class="bg-img" src="{{ $bgimg }}" alt="" style="display: none;">
        <div class="hero__inner">
            <div class="container">
                <div class="wrap-text left text-small font-bold {{ $textColor }}">
                    <h2 class="h2 mega-title {{ $textColor }}">DUNG & DIRK <br> The best choice for you</h2>
                    <div class="rte-setting mega-subtitle">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</div>
                    <a href="/sale.html" class="btn">Purchase Now</a>
                </div>
            </div>
        </div>
    </div>
</div>