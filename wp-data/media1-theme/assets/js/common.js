// ふわっと表示
var isScrollFirstAnimated = false;
var scrollAnimationFunc = function () {
  var scrollFirstElm = document.querySelector('.js-scroll-first');
  var scrollUpElms = document.querySelectorAll('.js-scroll-up');
  var scrollDownElms = document.querySelectorAll('.js-scroll-down');
  var triggerMargin = 100;
  if (scrollFirstElm && !isScrollFirstAnimated) {
    if (window.innerHeight > scrollFirstElm.getBoundingClientRect().top + triggerMargin) {
      scrollFirstElm.classList.add('is-on');
      isScrollFirstAnimated = true;
    }
  }
  for (var i = 0; i < scrollUpElms.length; i++) {
    if (scrollUpElms[i] && window.innerHeight > scrollUpElms[i].getBoundingClientRect().top + triggerMargin) {
      scrollUpElms[i].classList.add('is-on');
    }
  }
  for (var j = 0; j < scrollDownElms.length; j++) {
    if (scrollDownElms[j] && window.innerHeight > scrollDownElms[j].getBoundingClientRect().top + triggerMargin) {
      scrollDownElms[j].classList.add('is-on');
    }
  }
};
document.addEventListener('DOMContentLoaded', function () {
  scrollAnimationFunc();
  window.addEventListener('scroll', scrollAnimationFunc);
});


// ハンバーガーメニュー
document.querySelector('.js-trigger-btn').addEventListener('click', function(){
  this.classList.toggle('is-active');
  document.querySelector('.header__menu-trigger').classList.toggle('is-active');
  document.querySelector('.header__nav').classList.toggle('is-active');
  document.querySelector('html').classList.toggle('is-active');
});


// スムーススクロール
const smoothScrollTrigger = document.querySelectorAll('a[href^="#"]');
  for (let i = 0; i < smoothScrollTrigger.length; i++){
    smoothScrollTrigger[i].addEventListener('click', (e) => {
      e.preventDefault();
      let href = smoothScrollTrigger[i].getAttribute('href');
			let targetElement = document.getElementById(href.replace('#', ''));
      const rect = targetElement.getBoundingClientRect().top;
      const offset = window.pageYOffset;
      const gap = 0;
      const target = rect + offset - gap;
      window.scrollTo({
        top: target,
        behavior: 'smooth',
      });
    });
  }


// ページトップに戻るボタン
window.addEventListener('scroll', function(){
  let topBtn = document.querySelector('.footer__backtop');
  const scrollPosition = window.pageYOffset;
  if (scrollPosition >= 600) {
    topBtn.classList.add('is-active');
  } else {
    topBtn.classList.remove('is-active');
  }
  const scrollHeight = document.body.clientHeight;
  const windowHeight = window.innerHeight;
  const footer = document.querySelector('footer');
  const footerHeight = footer.offsetHeight;
  if (scrollHeight - scrollPosition - windowHeight <= footerHeight) {
    topBtn.classList.add('is-stop');
  } else {
    topBtn.classList.remove('is-stop');
  }
});


// 企業情報のサイドメニューのスクロール位置
const sectionArr = new Array(),
	elIndex = $('.company__sidemenu-link');
for(i=0; i < elIndex.length; i++){
	const elLink = elIndex.eq(i).attr('href');
	sectionArr[i] = elLink;
}
$(window).on('load resize scroll', function(){
	const top = $(window).scrollTop() + ($(window).height() / 2);
	for(i=0; i < sectionArr.length; i++){
		const target = sectionArr[i],
			secTop = $(target).offset().top,
			secBottom = secTop + $(target).outerHeight(true);
		if(secTop <= top && secBottom >= top){
			elIndex.removeClass('is-on');
			elIndex.eq(i).addClass('is-on');
		}
	}
});


$(function(){
  // アコーディオン
  $(".about__accordion-detail").hide();
  $(".js-about-trigger").click(function(){
    $(".js-about-trigger").prev().slideToggle();
    $(this).toggleClass("is-active");
  });
  $('.js-faq-trigger').click(function(){
    $(this).toggleClass('is-active');
    $(this).next('.contact__faq-description').slideToggle();
  });
  $('.js-detail-trigger').click(function(){
    $(this).toggleClass('is-active');
    $(this).next('.results__shop-details').slideToggle();
  });

  // ファイルのアップロード
  $('input[type="file"]').on('change', function () {
    var file = $(this).prop('files')[0];
    $('.form__item-file-note').text(file.name);
  });

  // セレクトボックスのpuraceholder
  $('select').on('change', function(){
    if($(this).val() == "placeholder"){
      $(this).css('color','#928F8F')
    } else {
      $(this).css('color','#333')
    }
  });
});


// 商品ページ
// 商品詳細のスライダー
var swiper = new Swiper(".content__swiper", {
  spaceBetween: 8,
  slidesPerView: 4.440475,
  breakpoints: {
    768: {
      spaceBetween: 10,
      slidesPerView: 4.4,
    },
  },
});
// 選択した画像をメインに表示
const thumbs = document.querySelectorAll('.content__swiper-img');
thumbs.forEach(function(img,index){
  img.onclick = function(){

    const mainImg = document.getElementById('js-product-mainImg');
    mainImg.src = this.dataset.image;
  }
});


// 商品詳細の関連商品のスライダー
var itemSwiper = new Swiper(".related__swiper", {
  spaceBetween: 8,
  slidesPerView: 2.160709,
  breakpoints: {
    768: {
      spaceBetween: 20,
      slidesPerView: 4.3845,
    },
  },
  navigation: {
    prevEl: ".swiper-button-prev",
    nextEl: ".swiper-button-next",
  }
});






