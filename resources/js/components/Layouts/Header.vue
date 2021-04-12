<template>
  <div class="font-mono">
    <nav
      class="navbar navbar-expand-md bg-gradient-to-r from-blue-600 via-green-300 to-green-600 shadow-sm mb-4"
    >
      <div class="container">
        <div class="flex items-center font-bold">
          <img
            src="https://maintainance.bgfticketing.com/public/storage/logo.png"
            class="h-8 shadow rounded-full"
            alt=""
          />
          <span class="text-xl text-white ml-2">E-Portal</span>
        </div>
        <div class="flex justify-items-center">
          <span
            class="font-bold text-white cursor-pointer hover:underline ml-3 mt-1"
          >
            <router-link to="/">Home</router-link>
          </span>
          <span
            v-if="user.admin == true"
            class="font-bold text-white cursor-pointer hover:underline ml-3 mt-1"
          >
            <router-link to="/Employees">View Employees</router-link>
          </span>
        </div>

        <div class="flex float-right text-white">
          <div class="flex items-center font-bold">
            <a>
              {{ user.name }}
            </a>
            <a @click.prevent="logout" class="ml-2 cursor-pointer"> Logout </a>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: window.user,
    };
  },
  methods: {
    logout() {
      axios.post("/logout").then((res) => (window.location = "/login"));
    },
  },
};
</script>

<style>
</style>