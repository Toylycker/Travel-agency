<template>
  <Nav class='sticky-top' />
  <div class="container-fluid min-vh-100 " style="background-image:url('/img/flag.png'); background-size:auto;">
    <div :class="{ 'container-xxl g-0':$page.component != 'front/Welcome'&&$page.component != 'front/ContactUs'?true:false}">
      <slot></slot>
      <noscript>
      <div>
        <img src="https://mc.yandex.ru/watch/98544366" style="position:absolute; left:-9999px;" alt="" />
      </div>
    </noscript>
    </div>
  </div>
  <Footer />
</template>

<script setup>
import Nav from '@/Shared/Nav.vue';
import { onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Footer from '@/Shared/Footer.vue';

onMounted(() => {
  const yandexMetricaId = import.meta.env.VITE_YANDEX_METRICA_ID;
  (function(m,e,t,r,i,k,a){
    m[i]=m[i]||function(){
      (m[i].a=m[i].a||[]).push(arguments)
    };
    m[i].l=1*new Date();
    for (var j = 0; j < document.scripts.length; j++) {
      if (document.scripts[j].src === r) {
        return;
      }
    }
    k=e.createElement(t),
    a=e.getElementsByTagName(t)[0],
    k.async=1,
    k.src=r,
    a.parentNode.insertBefore(k,a)
  })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

  ym(yandexMetricaId, "init", {
    clickmap: true,
    trackLinks: true,
    accurateTrackBounce: true
  });
  

// Track page view on every Inertia navigation
  Inertia.on('success', (event) => {
    const url = event.detail.page.url;
    const title = 'needs to be configured later';
    
    // Track the page URL and title after navigation
    ym(yandexMetricaId, "hit", url, { title: title });
  });
});

</script>