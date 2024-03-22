// トップページ
// MVのスライダー
const topMvSwiper = new Swiper(".top__mv-swiper", {
  slidesPerView: 1,
  centeredSlides: true,
  loop: true,
  effect: "creative",
  creativeEffect: {
    limitProgress: 1,
    prev: {
      translate: ["-100%", "25%", 0],
      rotate: [0, 0, -15],

    },
    next: {
      translate: ["100%", "25%", 0],
      rotate: [0, 0, 15],

    },
  },
  breakpoints: {
    769: {
      slidesPerView: 2.1,
    },
  },
  navigation: {
    prevEl: ".swiper-button-prev",
    nextEl: ".swiper-button-next",
  }
});

// 動画の停止・再生制御
// 停止処理
const pauseVideo = () => {
  const videoElements = document.querySelectorAll('.top__mv-swiper-slide video');
  Array.prototype.slice.call(videoElements).forEach((e) => {
    e.pause();
    e.currentTime = 0;
  });
}
// 再生処理
const restartVideo = () => {
  const videoElement = document.querySelector('.top__mv-swiper-slide.swiper-slide-active video');
  if (videoElement) {
    videoElement.play();
  }
}

const triggerBtn = document.querySelectorAll('.top__mv .swiper-button-prev,.top__mv .swiper-button-next');

topMvSwiper.on('slideChange', function () {
  Array.prototype.slice.call(triggerBtn).forEach((e) => {
    e.addEventListener(('click'), () => {
      pauseVideo();
    });
  });
});

topMvSwiper.on('slideChangeTransitionEnd', function () {
  restartVideo();
});


// おすすめ商品のスライダー
var topProductSwiper = new Swiper(".product__swiper", {
  spaceBetween: 10,
  slidesPerView: 2.151,
  breakpoints: {
    768: {
      spaceBetween: 24,
      slidesPerView: 4.3845,
    },
  },
  navigation: {
    prevEl: ".swiper-button-prev",
    nextEl: ".swiper-button-next",
  }
});


// ブランド一覧の横スク
const listWrapperEl = document.querySelector('.side-scroll-list-wrapper');
const listEl = document.querySelector('.side-scroll-list');

gsap.to(listEl, {
  x: () => -(listEl.clientWidth - listWrapperEl.clientWidth),
  ease: 'none',
  scrollTrigger: {
    trigger: '.side-scroll',
    start: 'top -280px',
    end: () => `+=${listEl.clientWidth - listWrapperEl.clientWidth}`,
    scrub: true,
    pin: true,
    anticipatePin: 1,
    invalidateOnRefresh: true,
  },
});


// 3つの取り組みのスライダー
document.addEventListener('DOMContentLoaded', function () {
  var index = 1;
  document.getElementById('js-next-btn').addEventListener('click', function () {
    var frontElement = document.querySelector('.front');
    var leftElement = document.querySelector('.left');
    var rightElement = document.querySelector('.right');

    frontElement.classList.remove('front');
    frontElement.classList.add('left');

    leftElement.classList.remove('left');
    leftElement.classList.add('right');

    rightElement.classList.remove('right');
    rightElement.classList.add('front');
  });

  document.getElementById('js-prev-btn').addEventListener('click', function () {
    var frontElement = document.querySelector('.front');
    var leftElement = document.querySelector('.left');
    var rightElement = document.querySelector('.right');

    frontElement.classList.remove('front');
    frontElement.classList.add('right');

    leftElement.classList.remove('left');
    leftElement.classList.add('front');

    rightElement.classList.remove('right');
    rightElement.classList.add('left');
  });
});








