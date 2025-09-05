<template>
    <HeadNavigation />
    <IntroCarousel />
    <LastestNews />
</template>
<script>
import HeadNavigation from './HeadNavigation.vue';
import IntroCarousel from './IntroCarousel.vue';
import LastestNews from './LastestNews.vue';
export default {
    components: {
        HeadNavigation,
        IntroCarousel,
        LastestNews
    },
};
</script>
