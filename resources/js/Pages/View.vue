<template>
     <div class="min-h-screen font-mono" >
      <div v-if="data.employees != ''">
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