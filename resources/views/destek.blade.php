@extends('layouts.app')

@section('content')
<div class="contact_us_6">
    <div class="responsive-container-block container">
        <form class="form-box">
            <div class="container-block form-wrapper">
                <div class="mob-text">
                    <p class="text-blk contactus-head">
                        Bize Ulaşın, Adresiniz İçin En Uygun İnterneti Birlikte Belirleyelim.
                    </p>
                    <p class="text-blk contactus-subhead">
                        Altyapınızı kontrol edelim, size en hızlı ve en avantajlı internet paketlerini sunalım.
                    </p>
                </div>
                <div class="responsive-container-block" id="i2cbk">
                    <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="i10mt-3">
                        <p class="text-blk input-title">
                            Adınız Soyadınız
                        </p>
                        <input class="input" id="ijowk-3" name="FirstName" placeholder="Lütfen adınızı ve soyadınızı yazınız...">
                    </div>

                    <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="ih9wi">
                        <p class="text-blk input-title">
                            Telefon Numaranız
                        </p>
                        <input class="input" id="imgis-3" name="PhoneNumber" placeholder="Lütfen cep telefon numaranızı başında 0 olmadan tuşlayınız...">
                    </div>
                    <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="i634i-3">
                        <p class="text-blk input-title">
                            Ne Konuda Yardımcı Olabiliriz?
                        </p>
                        <textarea class="textinput" id="i5vyy-3" placeholder="Lütfen talebinizi yazınız..."></textarea>
                    </div>
                </div>
                <button class="submit-btn" id="w-c-s-bgc_p-1-dm-id-2">
                    Gönder
                </button>
            </div>
        </form>
        <div class="responsive-cell-block wk-desk-7 wk-ipadp-12 wk-tab-12 wk-mobile-12" id="i772w">
            <div class="map-part">
                <p class="text-blk map-contactus-head" id="w-c-s-fc_p-1-dm-id">
                    İletişim
                </p>
                <p class="text-blk map-contactus-subhead">
                <div>📞 +90 (242) 350 0 444</div>
                <div>✉️ info@quartbilisim.net</div>
                <div>📍 Güzeloba Mah, 2192. Sokak, Bina No:4, Daire No:11, Muratpaşa/Antalya</div>
                </p>
                <div class="social-media-links mob">
                    <a
                        href="https://www.youtube.com/channel/UC__oJKp-zAY8qXkrVwjr7iQ"
                        target="_blank"
                        aria-label="YouTube"
                        class="social-icon-link">

                        <svg
                            width="28"
                            height="28"
                            viewBox="0 0 24 24"
                            fill="#FF0000"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.498 6.186a2.978 2.978 0 00-2.097-2.107C19.53 3.5 12 3.5 12 3.5s-7.53 0-9.401.579A2.978 2.978 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a2.978 2.978 0 002.097 2.107C4.47 20.5 12 20.5 12 20.5s7.53 0 9.401-.579a2.978 2.978 0 002.097-2.107C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/>
                            <path d="M9.545 15.568L15.818 12 9.545 8.432v7.136z" fill="#fff"/>
                        </svg>
                    </a>

                    <a class="social-icon-link" href="https://www.facebook.com/issmanager" target="_blank" id="itixd">
                        <img class="link-img image-block" src="https://workik-widget-assets.s3.amazonaws.com/Footer1-83/v1/images/Icon-facebook.png">
                    </a>

                    <a class="social-icon-link" href="https://www.instagram.com/iss.manager/?hl=tr" target="_blank" id="izldf-2-2">
                        <img class="link-img image-block" src="https://workik-widget-assets.s3.amazonaws.com/Footer1-83/v1/images/Icon-instagram.png">
                    </a>
                </div>
                <div class="map-box container-block">
                    <iframe
                        src="https://www.google.com/maps?q=36.86266,30.79311&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>


                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* ===============================
    CONTACT US – FIXED & WIDE LAYOUT
    =============================== */

    .contact_us_6 * {
        font-family: Nunito, sans-serif;
        box-sizing: border-box;
    }

    .contact_us_6 .text-blk {
        margin: 0;
        line-height: 1.6;
    }

    /* ---------- MAIN CONTAINER ---------- */

    .contact_us_6 .responsive-container-block.container {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        padding: 80px 40px;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: 60px;
    }

    /* ---------- FORM SIDE ---------- */

    .contact_us_6 .form-box {
        flex: 0 0 55%;
        max-width: 55%;
    }

    .contact_us_6 .container-block.form-wrapper {
        width: 100%;
        max-width: 600px;
        background: #ffffff;
        padding: 50px 45px;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
    }

    /* ---------- FORM TEXT ---------- */

    .contact_us_6 .text-blk.contactus-head {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 10px;
        text-align: left;
    }

    .contact_us_6 .text-blk.contactus-subhead {
        font-size: 15px;
        color: #7a7a7a;
        margin-bottom: 35px;
    }

    /* ---------- INPUT GROUPS ---------- */

    .contact_us_6 .responsive-container-block {
        width: 100%;
    }

    .contact_us_6 .responsive-cell-block {
        margin-bottom: 22px;
    }

    .contact_us_6 .text-blk.input-title {
        font-size: 13px;
        font-weight: 600;
        color: #8a8a8a;
        margin-bottom: 6px;
        text-align: left;
    }

    /* ---------- INPUTS ---------- */

    .contact_us_6 input,
    .contact_us_6 textarea {
        width: 100%;
        border: 2px solid #eaeaea;
        border-radius: 8px;
        padding: 14px 16px;
        font-size: 15px;
        transition: border-color 0.2s ease;
    }

    .contact_us_6 textarea {
        min-height: 150px;
        resize: vertical;
    }

    .contact_us_6 input:focus,
    .contact_us_6 textarea:focus {
        outline: none;
        border-color: #03a9f4;
    }

    /* ---------- SUBMIT BUTTON ---------- */

    .contact_us_6 .submit-btn {
        width: 100%;
        height: 58px;
        border-radius: 999px;
        border: none;
        background: #03a9f4;
        color: #ffffff;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.15s ease;
    }

    .contact_us_6 .submit-btn:hover {
        background: #0288d1;
        transform: translateY(-1px);
    }

    /* ---------- MAP SIDE ---------- */

    .contact_us_6 #i772w {
        flex: 0 0 45%;
        max-width: 45%;
    }

    .contact_us_6 .map-part {
        width: 100%;
    }

    .contact_us_6 .text-blk.map-contactus-head {
        font-size: 22px;
        font-weight: 800;
        color: #03a9f4;
        margin-bottom: 8px;
    }

    .contact_us_6 .text-blk.map-contactus-subhead {
        font-size: 14px;
        color: #666;
        margin-bottom: 24px;
        max-width: 420px;
    }

    /* ---------- SOCIAL ICONS ---------- */

    .contact_us_6 .social-media-links {
        display: flex;
        gap: 18px;
        margin-bottom: 24px;
    }

    .contact_us_6 .link-img {
        width: 28px;
        height: 28px;
    }

    /* ---------- MAP BOX ---------- */

    .contact_us_6 .map-box {
        width: 100%;
        height: 600px;
        border-radius: 14px;
        background-image: url("https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/sc23.png");
        background-size: cover;
        background-position: center;
    }

    /* ===============================
       RESPONSIVE
       =============================== */

    @media (max-width: 1024px) {
        .contact_us_6 .responsive-container-block.container {
            flex-direction: column;
            padding: 60px 24px;
        }

        .contact_us_6 .form-box,
        .contact_us_6 #i772w {
            max-width: 100%;
            flex: 0 0 100%;
        }

        .contact_us_6 .container-block.form-wrapper {
            max-width: 100%;
        }

        .contact_us_6 .map-box {
            height: 360px;
        }
    }

    @media (max-width: 480px) {
        .contact_us_6 .text-blk.contactus-head {
            font-size: 28px;
        }

        .contact_us_6 .submit-btn {
            font-size: 16px;
        }
    }

</style>
@endpush
