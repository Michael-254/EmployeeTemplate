<template>
  <div class="min-h-screen font-serif">
    <bridge-notify />
    <section class="max-w-5xl mx-auto">
      <div class="border rounded-md shadow-md mt-4 bg-white px-3">
        <h3 class="text-center text-xl text-blue-700 font-bold font-sans m-2">
          Employees
        </h3>

        <div class="flex float-center mb-2 space-x-2">
          <select
            v-model="site"
            class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
          >
            <option value="">-- Filter by Site --</option>
            <option value="Head Office">Head Office</option>
            <option value="Kiambere">Kiambere</option>
            <option value="Dokolo">Dokolo</option>
            <option value="Nyongoro">Nyongoro</option>
            <option value="7 Forks">7 Forks</option>
            <option value="Sosoma">Sosoma</option>
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
          <select
            v-model="filterId"
            type="text"
            class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
          >
            <option value="">-- Filter By Name after selecting Dept --</option>
            <option
              v-for="filter in filters"
              :key="filter.id"
              :value="filter.id"
            >
              {{ filter.name }}
            </option>
          </select>
          <button
            @click.prevent="reset"
            class="items-center space-x-2 px-3 py-2 border border-green-400 rounded-md bg-red-500 text-white text-xs leading-4 font-medium uppercase tracking-wider focus:outline-none hover:bg-red-900"
          >
            Reset
          </button>
        </div>
        <div class="flex justify-between px-2 py-1 text-green-500">
          <div class="flex">
            <span
              >You have currently selected {{ checked.length }} records</span
            >
            <p
              class="ml-2 text-blue-500 cursor-pointer hover:underline"
              @click="selectAll"
            >
              Select All
            </p>
            <p
              v-if="checked.length > 0"
              class="ml-2 text-red-500 cursor-pointer hover:underline"
              @click="RemoveSelected"
            >
              Unselect
            </p>
          </div>
          <a
            v-if="checked.length > 0"
            :href="url"
            class="items-center space-x-2 px-3 py-2 border border-green-400 rounded-md bg-green-500 text-white text-xs leading-4 font-medium uppercase tracking-wider focus:outline-none hover:bg-blue-700"
          >
            Export to Excel
          </a>
        </div>

        <div v-if="Success" class="bg-blue-100 border-blue-500 text-blue-700 px-4 py-3" role="alert">
          <p class="font-bold">Success</p>
          <p class="text-sm">User created Successfully.</p>
        </div>

        <div class="flex justify-center">
          <div class="bg-white shadow-lg rounded my-6">
            <table class="text-left w-full">
              <thead>
                <tr>
                  <th
                    class="py-4 px-6 text-xl border-b text-green-500 font-bold"
                  >
                    <input type="checkbox" id="checkbox" disabled />
                  </th>
                  <th
                    class="py-4 px-6 text-xl border-b text-green-500 font-bold"
                  >
                    Name
                  </th>
                  <th
                    class="py-4 px-6 border-b text-xl text-green-500 font-bold"
                  >
                    Department
                  </th>
                  <th
                    class="py-4 px-6 border-b text-xl text-green-500 font-bold"
                  >
                    Email
                  </th>
                  <th
                    class="py-4 px-6 border-b text-xl text-green-500 font-bold"
                  >
                    Site
                  </th>
                  <th
                    class="py-4 px-6 border-b text-xl text-green-500 font-bold"
                  >
                    View
                  </th>
                </tr>
              </thead>
              <tbody name="list" is="transition-group">
                <tr
                  class="hover:bg-grey-lighter"
                  v-for="user in data.data"
                  :key="user.id"
                >
                  <td class="py-4 px-6 border-b border-green-light">
                    <input
                      type="checkbox"
                      id="checkbox"
                      :value="user.id"
                      v-model="checked"
                    />
                  </td>
                  <td class="py-4 px-6 border-b border-green-light">
                    {{ user.name }}
                  </td>
                  <td class="py-4 px-6 border-b border-green-light">
                    {{ user.department }}
                  </td>
                  <td class="py-4 px-6 border-b border-green-light">
                    {{ user.email }}
                  </td>
                  <td class="py-4 px-6 border-b border-green-light">
                    {{ user.site }}
                  </td>
                  <td class="py-4 px-6 border-b border-green-light">
                    <span class="font-bold cursor-pointer text-green-600">
                      <router-link
                        :to="{ name: 'user.details', params: { id: user.id } }"
                        ><i class="fas fa-eye"></i></router-link
                      >
                    </span>
                  </td>
                </tr>
              </tbody>
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
      site: "",
      checked: [],
      url: "",
      user: window.user,
      Success: false,
    };
  },
  watch: {
    filterId(value) {
      this.getResults();
    },
    site(value) {
      this.getResults();
      this.checked = [];
    },
    dept(value) {
      this.getResults();
      axios.get("/SelectedDept?dept=" + this.dept).then((response) => {
        this.filters = response.data.filter;
        this.checked = [];
      });
    },
    checked(value) {
      this.url = "/Export/" + this.checked;
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
            this.dept +
            "&site=" +
            this.site
        )
        .then((response) => {
          this.data = response.data.data;
        });
    },
    selectAll() {
      axios
        .get("/selectAll?dept=" + this.dept + "&site=" + this.site)
        .then((response) => {
          this.checked = response.data;
        });
    },
    RemoveSelected() {
      this.checked = [];
    },
    reset() {
      this.filterId = "";
      this.dept = "";
      this.site = "";
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