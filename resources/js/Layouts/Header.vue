<script setup>
const links = [
    {url:"viber://chat?number=34643598874",text:"In Viber"},
    {url:"https://t.me/+34643598874",text:"In Telegram"},
    {url:"https://wa.me/34643598874",text:"In Whatsapp"},
    {url:"tel:+34643598874",text:"+34643598874"}
]
const logo = new URL('@/img/logo.svg', import.meta.url).href;
const portmone = new URL('@/img/portmone.svg', import.meta.url).href;
const manager = new URL('@/img/manager.svg', import.meta.url).href;
const your_route = new URL('@/img/your_route.svg', import.meta.url).href;

const telegram = new URL('@/img/telegram.svg', import.meta.url).href;
const whatsapp = new URL('@/img/whatsapp.svg', import.meta.url).href;
const viber = new URL('@/img/viber.svg', import.meta.url).href;

</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <router-link class="navbar-brand" to="/">
                <img class="main-logo" :src="logo" alt="comfy mover">
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item nav-item-questions">Questions?</li>
                    <li class="nav-item">
                        <router-link class="nav-link nav-link-big" :to="links[3].url"> Call {{links[3].text}}</router-link>
                        <span class="special-text-under-phone">
                            available in: Viber <img :src="viber" alt="{{links[0].text}}" title="{{links[0].text}}"/> &nbsp;&nbsp; Whatsapp <img :src="whatsapp" alt="{{links[2].text}}" title="{{links[2].text}}"/> &nbsp;&nbsp; Telegram <img :src="telegram" alt="{{links[1].text}}" title="{{links[1].text}}"/>
                        </span>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="under-nav">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <img class="un-icon" :src="your_route" alt="">
                    <span class="un-point">
                        Get Cost of Your Route Immediately <br>
                        No Email or Telephone Needed From You
                    </span>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <img class="un-icon" :src="manager" alt="">
                    <span class="un-point">
                        Any Questions Any Time <br>
                        Manager Is In Contact With You 24/7
                    </span>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <img class="un-icon" :src="portmone" alt="">
                    <span class="un-point">
                        No Prepayment Needed. <br>
                        Pay After Discussing Details With Manager
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
