<template>
  <div class="min-h-screen font-serif" >
     <bridge-notify />
     <div>
       <h3 class="text-blue-500 text-center font-bold text-xl">{{ data.name }} Information Sheet</h3>
       <div class="flex justify-center items-center mt-1">
       <i class="fas fa-file mr-1 text-blue-600"></i>
       <router-link class="text-blue-600 font-bold" :to="{ name: 'view.pdf', params: { id: data.id } }">Generate PDF</router-link>
       </div>
     </div>
        <app-employee :form="data.employees" :can="canWrite" @reloadData='fetchData'/>
        <app-jobinfo :form="data.job_infos" :can="canWrite" @reloadData='fetchData'/>
        <app-emergencyC :form="data.emergency" :can="canWrite" @reloadData='fetchData'/>
        <app-image :docs="data.images" :can="canWrite" @reloadData='fetchData'/>
        <app-companyAsset :docs="data.assets" :can="canWrite" @reloadData='fetchData'/>
        <app-training :docs="data.trainings" :can="canWrite" @reloadData='fetchData'/>
  </div>
</template>

<script>
import AppEmployee from "../components/Admin/Employee";
import AppJobinfo from "../components/Admin/JobInfo";
import AppEmergencyC from "../components/Admin/EmergencyC";
import AppImage from "../components/Admin/Image";
import AppCompanyAsset from "../components/Admin/CompanyAsset";
import AppTraining from "../components/Admin/Training";
export default {
    components: {AppEmployee, AppJobinfo,AppEmergencyC,AppImage,AppCompanyAsset,AppTraining},
    mounted() {
        this.fetchData();
    }, 

    data(){
      return {
        data: [],
        canWrite: "",
      }
    },

    methods: {
       fetchData(){
            axios
                .get("/Employee-details/" + this.$route.params.id)
                .then((response) => {
                    this.data = response.data.user;
                    this.canWrite = response.data.canwrite;
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