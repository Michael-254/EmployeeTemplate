<template>
     <div class="min-h-screen" >
      <div v-if="data.employees != ''">
              <router-link to="/Employees">
                <div class="flex items-center mb-1 cursor-pointer text-blue-600 hover:underline lg:px-12">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z" />
                  </svg>Go Back
                </div>
              </router-link>                 
        <app-employeeedit :forms="data"/>
      </div>
      <div v-else>
        <div class="border rounded-md shadow-md text-center max-w-4xl mx-auto h-32 font-bold">
          <h2 class="text-red-700 text-xl "> No data Available yet</h2>
        </div>
      </div>
  </div>
</template>

<script>
import AppEmployeeedit from "../components/Admin/EmployeeEdit";
export default {
  components: {AppEmployeeedit},
   mounted() {
        this.fetchData();
    }, 

    data(){
      return {
        data: [],
      }
    },

    methods: {
       fetchData(){
            axios
                .get("/EmployeeView/" + this.$route.params.id)
                .then((response) => {
                    this.data = response.data;
                })
                .catch((e) => {
                    this.errors = e.response.data;
                });
        },
    }

}
</script>

<style>

</style>