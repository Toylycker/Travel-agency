<template>
    <Head :title="$t('Welcome')">
      <meta name="description" content="Welcome to our travel company! Discover the wonders of Turkmenistan with our expertly guided tours and personalized travel experiences. Plan your unforgettable journey today.">
      <meta name="keywords" content="Turkmenistan travel, welcome to Turkmenistan, Turkmenistan tours, travel experiences, guided tours, explore Turkmenistan">
    </Head>
    <header>
      <div class="text-white">{{$t('WelcomeToSunnyTurkmenistan')}}</div>
      <div><a class="text-wt" href="https://jahankeshde.ru" >{{$t('EnjoyTravellingWithUs')}}</a></div>
    </header>
    <section class="first">
      <div class="outer">
        <div class="inner">
          <div class="bg">
            <div class="container g-0mt-3 h-50">
              <h2 class="section-heading">{{$t('Turkmenistan')}}</h2>
              <div class="container-fluid text-center">
  
                  <div class="col-12 bg-white rounded">
                    <p class="m-3 overflow-auto">
                      {{$t('TurkmenistanText')}}
                    </p>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  
    <section class="second">
      <div class="outer">
        <div class="inner">
          <div class="bg">
            <div class="container g-0 mt-3">
              <h2 class="section-heading">{{$t('Ashgabat')}}</h2>
              <div class="container text-center" >
                <div class="row g-0 bg-white rounded">
                  <div class="col-12">
                    <p class="m-3">
                      {{$t('AshgabatText')}}
                    </p>
                  </div>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="third">
      <div class="outer">
        <div class="inner">
          <div class="bg">
            <div class="container g-0mt-3 h-50 ">
              <h2 class="section-heading">{{$t('Akhal')}}</h2>
              <div class="container text-center">
                <div class="row g-0 bg-white rounded">
                  <div class="col-12">
                    <p class="m-3">T{{$t('AkhalText')}}</p>
                  </div>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="fourth">
      <div class="outer">
        <div class="inner">
          <div class="bg">
            <div class="container g-0mt-3 h-50">
              <h2 class="section-heading">{{$t('Balkan')}}</h2>
              <div class="container text-center">
                <div class="row g-0 bg-white rounded">
                  <div class="col-12">
                    <p class="m-3">{{$t('BalkanText')}}</p>
                  </div>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="fifth">
      <div class="outer">
        <div class="inner">
          <div class="bg">
            <div class="container g-0mt-3 h-50">
              <h2 class="section-heading">{{$t('Lebap')}}</h2>
              <div class="container text-center">
                <div class="row g-0 bg-white rounded">
                  <div class="col-12">
                    <p class="m-3"> {{$t('LebapText')}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="sixth">
      <div class="outer">
        <div class="inner">
          <div class="bg">
            <div class="container g-0mt-3 h-50">
              <h2 class="section-heading">{{$t('Dashoguz')}}</h2>
              <div class="container text-center">
                <div class="row g-0 bg-white rounded">
                  <div class="col-12">
                    <p class="m-3">{{$t('DashoguzText')}}</p>
                  </div>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="seventh">
      <div class="outer">
        <div class="inner">
          <div class="bg">
            <div class="container g-0mt-3 h-50">
              <h2 class="section-heading">{{$t('Mary')}}</h2>
              <div class="container text-center">
                <div class="row g-0 bg-white rounded">
                  <div class="col-12">
                    <p class="m-3">{{$t('MaryText')}}</p>
                  </div>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import Place from '@/Shared/Place.vue';
import gsap from "gsap";
import { Sine } from 'gsap/all';
import { Observer } from 'gsap/Observer';
import { onMounted, onBeforeUnmount, onUnmounted, ref } from 'vue';
import {NSpin} from 'naive-ui';

gsap.registerPlugin(Observer);
let observer = 0;
onMounted(() => {
  let sections = document.querySelectorAll("section"),
    images = document.querySelectorAll(".bg"),
    headings = gsap.utils.toArray(".section-heading"),
    outerWrappers = gsap.utils.toArray(".outer"),
    innerWrappers = gsap.utils.toArray(".inner"),
    // splitHeadings = headings.map(heading => new SplitText(heading, { type: "chars,words,lines", linesClass: "clip-text" })),
    currentIndex = -1,
    // wrap = gsap.utils.wrap(0, sections.length - 1), 
    wrap = gsap.utils.wrap(0, sections.length),
    animating;

  gsap.set(outerWrappers, { yPercent: 100 });
  gsap.set(innerWrappers, { yPercent: -100 });

  function gotoSection(index, direction) {
    index = wrap(index); // make sure it's valid
    animating = true;
    let fromTop = direction === -1,
      dFactor = fromTop ? -1 : 1,
      tl = gsap.timeline({
        defaults: { duration: 1.25, ease: "power1.inOut" },
        onComplete: () => animating = false
      });
    if (currentIndex >= 0) {
      // The first time this function runs, current is -1
      gsap.set(sections[currentIndex], { zIndex: 0 });
      tl.to(images[currentIndex], { yPercent: -15 * dFactor })
        .set(sections[currentIndex], { autoAlpha: 0 });
    }
    gsap.set(sections[index], { autoAlpha: 1, zIndex: 1 });
    tl.fromTo([outerWrappers[index], innerWrappers[index]], {
      yPercent: i => i ? -100 * dFactor : 100 * dFactor
    }, {
      yPercent: 0
    }, 0)
      .fromTo(images[index], { yPercent: 15 * dFactor }, { yPercent: 0 }, 0)
    // .fromTo(splitHeadings[index].chars, { 
    //     autoAlpha: 0, 
    //     yPercent: 150 * dFactor
    // }, {
    //     autoAlpha: 1,
    //     yPercent: 0,
    //     duration: 1,
    //     ease: "power2",
    //     stagger: {
    //       each: 0.02,
    //       from: "random"
    //     }
    //   }, 0.2);

    currentIndex = index;
  }

  observer = Observer.create({
    type: "wheel,touch,pointer",
    wheelSpeed: -1,
    onDown: () => !animating && gotoSection(currentIndex - 1, -1),
    onUp: () => !animating && gotoSection(currentIndex + 1, 1),
    tolerance: 10,
    preventDefault: true
  });

  gotoSection(0, 1);

  // original: https://codepen.io/BrianCross/pen/PoWapLP
  // horizontal version: https://codepen.io/GreenSock/pen/xxWdeMK

});

onBeforeUnmount(() => {
  observer.disable();
});
function disOb() {
  observer.disable();
  console.log('entered');
}
function playOb() {
  observer.enable();
  console.log('left');
}

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>





<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Cormorant+Garamond&display=swap");

$bg-gradient: linear-gradient(180deg,
    rgba(0, 0, 0, 0.6) 0%,
    rgba(0, 0, 0, 0.3) 100%);

// * {
// box-sizing: border-box;
// user-select: none;
// }

// a {
//   color: #fff;
//   text-decoration: none;
// }

// body {
// margin: 0;
// padding: 0;
// height: 100vh;
// color: white;
// background: black;
// font-family: "Cormorant Garamond", serif;
// text-transform: uppercase;
// }

h2 {
  font-size: clamp(1rem, 5vw, 5rem);
  font-weight: 400;
  text-align: center;
  letter-spacing: 0.5em;
  margin-right: -0.5em;
  color: white;
  width: 90vw;
  max-width: 1200px;
}

header {
  position: fixed;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 5%;
  width: 100%;
  z-index: 3;
  height: 7em;
  font-family: "Bebas Neue", sans-serif;
  font-size: clamp(0.66rem, 2vw, 1rem);
  letter-spacing: 0.5em;
}

section {
  height: 100%;
  width: 100%;
  // top: 0;
  left: 0;
  position: fixed;
  visibility: hidden;

  .outer,
  .inner {
    width: 100%;
    height: 100%;
    overflow-y: hidden;
  }

  .bg {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    background-size: cover;
    background-position: center;

    h2 {
      z-index: 2;
    }

    .clip-text {
      overflow: hidden;
    }
  }
}

.first {
  .bg {
    background-image: $bg-gradient,
      url('/img/Turkmenistan.jpeg');
  }
}

.second {
  .bg {
    background-image: $bg-gradient,
      url('/img/Ashgabat.jpeg');
  }
}

.third {
  .bg {
    background-image: $bg-gradient,
      url('/img/Akhal.jpg');
  }
}

.fourth {
  .bg {
    background-image: $bg-gradient,
      url('/img/Balkan.jpg');
  }
}

.fifth {
  .bg {
    background-image: $bg-gradient,
      url('/img/Lebap.jpg');
    // background-position: 50% 45%;
  }
}

.sixth {
  .bg {
    background-image: $bg-gradient,
      url('/img/Dashoguz.jpg');
    // background-position: 50% 45%;
  }
}

.seventh {
  .bg {
    background-image: $bg-gradient,
      url('/img/Mary.png');
    // background-position: 50% 45%;
  }
}

h2 * {
  will-change: transform;
}

.bg-white {
  opacity: 0.8;
}

.img {
  object-fit: contain;
  opacity: 0.8;
}
</style>