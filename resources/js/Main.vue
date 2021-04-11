<template>
  <div>
      <app-header :user="user.name"/>
         <router-view></router-view>
      <app-footer/>
  </div>
</template>

<script>
import AppHeader from "./components/Layouts/Header";
import AppFooter from "./components/Layouts/Footer";
export default {
    components: {AppHeader, AppFooter},
    data(){
      return {
        user: window.user,
      }
    }
}
</script>

<style>

</style>