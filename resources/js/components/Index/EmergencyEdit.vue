<template>
  <div>
    <section
      class="max-w-3xl mx-auto mt-3 font-mono"
      v-for="form in form"
      :key="form.id"
    >
      <form @submit.prevent="update(form)">
        <div class="bg-white lg:flex lg:shadow-lg lg:rounded-lg">
          <div class="p-3">
            <span
              @click="showForm = !showForm"
              class="text-xl text-green-500 font-bold md:text-xl cursor-pointer"
              >Emergency Contact Information</span
            >
            <transition name="slide-fade">
              <div v-if="showForm">
                <div class="mt-2">
                  <p class="text-xs text-gray-500">
                    Kindly fill all the fields.If you are not sure of others
                    save and come back later
                  </p>
                </div>
                <div class="mt-4 flex space-x-2">
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold">Full Name</label>
                    <input
                      v-model="form.Fname"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                </div>

                <div class="mt-2 flex space-x-2">
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold"
                      >Street Address</label
                    >
                    <input
                      v-model="form.street"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold"
                      >Apartment/Unit</label
                    >
                    <input
                      v-model="form.apartment"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                </div>

                <div class="mt-2 flex space-x-2">
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold">City</label>
                    <input
                      v-model="form.city"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold">State</label>
                    <input
                      v-model="form.state"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold">Zip Code</label>
                    <input
                      v-model="form.Zcode"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                </div>

                <div class="mt-2 flex space-x-2">
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold"
                      >Primary Phone</label
                    >
                    <input
                      v-model="form.Pphone"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold"
                      >Alternate Phone:</label
                    >
                    <input
                      v-model="form.Aphone"
                      type="text"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    />
                  </div>
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold"
                      >Relationship</label
                    >
                    <textarea
                      v-model="form.relationship"
                      class="w-full py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    ></textarea>
                  </div>
                </div>

                <div class="flex float-right mt-2">
                  <button
                    class="items-center px-3 py-2 bg-green-500 border rounded-md text-xs text-white hover:bg-blue-800 focus:outline-none focus:ring ring-gray-300 transition ease-in-out duration-150"
                  >
                    Save
                  </button>
                </div>
              </div>
            </transition>
          </div>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
export default {
  props: ["form"],
  data() {
    return {
      showForm: false,
      IsMarried: false,
      user: window.user,
    };
  },

  methods: {
    update(form) {
      axios
        .put(`updateC/${form.id}`, this.form[0])
        .then((response) => {
          this.$notify({ message: "Updated Successfully" });
          this.showForm = false;
          this.$emit("reloadData");
        })
        .catch((e) => {
          this.errors = e.response.data.errors;
        });
    },
  },
};
</script>

<style>
.slide-fade-enter-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
</style>