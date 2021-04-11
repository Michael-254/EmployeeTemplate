<template>
  <div class="min-h-screen font-mono" >
     <bridge-notify />
    <div v-if="data.dataA != ''">
      <app-employeeedit :form="data.dataA" @reloadData='fetchData'/>
    </div>
    <div v-else>
      <app-employee @reloadData='fetchData'/>
    </div>
      <div v-if="data.dataB == ''">
        <app-jobinfo @reloadData='fetchData'/>
      </div>
      <div  v-else>
        <app-jobinfoEdit :form="data.dataB" @reloadData='fetchData'/>
      </div>
      <div v-if="data.dataC == ''">
        <app-emergencyC @reloadData='fetchData'/>
      </div>
      <div  v-else>
        <app-emergencyEdit :form="data.dataC" @reloadData='fetchData'/>
      </div>
      <div>
        <app-image :docs="data.dataD" @reloadData='fetchData'/>
      </div>
  </div>
</template>

<script>
import AppEmployee from "../components/index/Employee";
import AppEmployeeedit from "../components/index/EmployeeEdit";
import AppJobinfo from "../components/index/JobInfo";
import AppJobinfoEdit from "../components/index/JobInfoEdit";
import AppEmergencyC from "../components/index/EmergencyC";
import AppEmergencyEdit from "../components/index/EmergencyEdit";
import AppImage from "../components/index/Image";
export default {
    components: {AppEmployee, AppEmployeeedit,AppJobinfo,AppJobinfoEdit,AppEmergencyC,AppEmergencyEdit,AppImage},
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
                .get("/index")
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