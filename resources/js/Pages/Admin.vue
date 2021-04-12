<template>
  <div class="min-h-screen font-mono">
    <section class="max-w-5xl mx-auto">
      <div class="border rounded-md shadow-md mt-4 bg-white px-3">
        <h3 class="text-center text-xl text-blue-700 font-bold font-sans m-2">
          Employees
        </h3>

        <div class="flex float-center mb-2 space-x-2">
          <select
            v-model="filterId"
            type="text"
            class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
          >
            <option value="">-- Filter By Name --</option>
            <option
              v-for="filter in filters"
              :key="filter.id"
              :value="filter.id"
            >
              {{ filter.name }}
            </option>
          </select>
          <select
            v-model="dept"
            class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
          >
            <option value="">-- Filter by Department --</option>
            <option value="Management">Management</option>
            <option value="Forestry">Forestry</option>
            <option value="Human Resources">HR</option>
            <option value="Information Technology">IT</option>
            <option value="Operations">Operations</option>
            <option value="Accounts">Accounts</option>
            <option value="M&E">Monitoring and Evaluation</option>
            <option value="Miti Magazine">Miti Magazine</option>
            <option value="Communications">Communications</option>
          </select>
        </div>
        <div class="flex justify-center">
          <div class="bg-white shadow-md rounded my-6">
            <table class="text-left w-full border-collapse">
              <transition-group name="list" tag="p">
                <tbody v-for="user in data.data" :key="user.id">
                  <tr class="hover:bg-grey-lighter">
                    <td class="py-4 px-6 border-b border-grey-light">
                      <span class="font-bold badge badge-success"> Name: </span>
                      {{ user.name }}
                    </td>
                    <td class="py-4 px-6 border-b border-grey-light">
                      <span class="font-bold badge badge-danger text-white">
                        Dept:
                      </span>
                      {{ user.department }}
                    </td>
                    <td class="py-4 px-6 border-b border-grey-light">
                      <span class="font-bold badge badge-primary"> Site: </span>
                      {{ user.site }}
                    </td>
                    <td class="py-4 px-6 border-b border-grey-light">
                      <span
                        class="badge badge-warning font-bold cursor-pointer"
                      >
                        <router-link
                          :to="{ name: 'admin.view', params: { id: user.id } }"
                          >View Details</router-link
                        >
                      </span>
                    </td>
                  </tr>
                </tbody>
              </transition-group>
            </table>
            <div class="mt-3">
              <pagination
                :data="data"
                @pagination-change-page="getResults"
              ></pagination>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  middleware: "auth",
  mounted() {
    this.getResults();
  },

  data() {
    return {
      data: {},
      filters: {},
      filterId: "",
      dept: "",
      user: window.user,
    };
  },
  watch: {
    filterId(value) {
      this.getResults();
    },
    dept(value) {
      this.getResults();
    },
  },
  methods: {
    getResults(page = 1) {
      axios
        .get(
          "/Admin?page=" +
            page +
            "&filterId=" +
            this.filterId +
            "&dept=" +
            this.dept
        )
        .then((response) => {
          this.data = response.data.data;
          this.filters = response.data.filter;
        });
    },
  },
};
</script>

<style>
.list-item {
  display: inline-block;
  margin-right: 10px;
}
.list-enter-active,
.list-leave-active {
  transition: all 1s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateX(-30px);
}
</style>