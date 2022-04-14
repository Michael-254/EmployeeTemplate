<template>
  <div>
    <section class="max-w-3xl mx-auto mt-3 font-serif">
      <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="bg-white lg:flex lg:shadow-lg lg:rounded-lg">
          <div class="p-3 w-full">
            <span
              @click="showForm = !showForm"
              class="text-xl text-green-500 font-bold md:text-xl cursor-pointer"
              >Trainings Attended by this Employee</span
            >
            <transition name="slide-fade">
              <div v-if="showForm">

                <div v-if="can == true">
                <div class="mt-2">
                  <p class="text-xs text-gray-500">
                    List All Trainings and attach certificated if available
                  </p>
                </div>
                <div class="mt-2 flex space-x-2">
                  <div class="flex-1">
                    <label class="text-blue-500 font-semibold"
                      >Training Name</label
                    >
                    <input
                      v-model="trainingName"
                      class="
                        w-full
                        py-2
                        px-2
                        bg-gray-200
                        rounded-lg
                        shadow-sm
                        focus:outline-none focus:shadow-outline
                        text-gray-600
                      "
                      placeholder="Type training name"
                    />
                    <p class="text-sm text-red-600" v-if="errors.trainingName">{{
                      errors.trainingName[0]
                    }}</p>
                    <label class="text-blue-500 font-semibold mt-2"
                      >Date completed</label
                    >
                     <datepicker
                      v-model="date"
                      name="uniquename"
                      class="py-2 px-2 bg-gray-200 rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600"
                    ></datepicker>
                    <p class="text-sm text-red-600" v-if="errors.date">{{
                      errors.date[0]
                    }}</p>
                     <input
                      type="file"
                      class="form-control mt-3"
                      @change="onChange"
                      ref="fileupload"
                    />
                  </div>
                </div>

                <div class="flex float-right mt-2 mb-4">
                  <button
                    class="
                      items-center
                      px-3
                      py-2
                      bg-green-500
                      border
                      rounded-md
                      text-xs text-white
                      hover:bg-blue-800
                      focus:outline-none focus:ring
                      ring-gray-300
                      transition
                      ease-in-out
                      duration-150
                    "
                  >
                    Save
                  </button>
                </div>

                </div>

                <div>
                  <table class="text-left w-full border-collapse mt-2">
                    <transition-group name="list" tag="p">
                      <tbody v-for="doc in docs" :key="doc.id">
                        <tr class="hover:bg-grey-lighter">
                          <td>
                            <div
                              class="border rounded-md shadow-md p-2 flex mr-2"
                            >
                              <p class="font-semibold text-blue-600 mr-2">
                                Document Name:
                              </p>
                              {{ doc.training_name }} 
                            </div>
                          </td>
                          <td>
                            <div
                              class="border rounded-md shadow-md p-2 flex mr-2"
                            >
                              <p class="font-semibold text-blue-600 mr-2">
                                Date Graduated:
                              </p>
                              {{  new Date(doc.date_completed).toLocaleDateString()}}
                            </div>
                          </td>
                          <td v-if="doc.file">
                            <div
                              class="border rounded-md shadow-md p-2 flex mr-2"
                            >
                              <p class="font-semibold text-blue-600 mr-2">
                                File Name:
                              </p>
                              {{ doc.file }} 
                            </div>
                          </td>
                          <td>
                            <div class="border rounded-md shadow-md p-2 mr-2">
                              <a
                                @click.prevent="view(doc)"
                                class="
                                  cursor-pointer
                                  items-center
                                  px-3
                                  py-2
                                  bg-blue-500
                                  border
                                  rounded-md
                                  text-xs text-white
                                  hover:bg-blue-800
                                  focus:outline-none focus:ring
                                  ring-gray-300
                                  transition
                                  ease-in-out
                                  duration-150
                                "
                                >Open</a
                              >
                            </div>
                          </td>
                          <td>
                            <div class="border rounded-md shadow-md p-2 mr-2">
                              <button
                                @click.prevent="destroy(doc)"
                                :disabled="can == false"
                                class="
                                  items-center
                                  px-3
                                  py-2
                                  bg-red-500
                                  border
                                  rounded-md
                                  text-xs text-white
                                  hover:bg-red-800
                                  focus:outline-none focus:ring
                                  ring-gray-300
                                  transition
                                  ease-in-out
                                  duration-150
                                "
                              >
                                Delete
                              </button>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </transition-group>
                  </table>
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
import Datepicker from "vuejs-datepicker";
export default {
  components: { Datepicker },
  props: ["docs","can"],
  data() {
    return {
      showForm: false,
      user: window.user,
      file: "",
      trainingName: "",
      date: "",
      errors: {},
      employee_id: this.$route.params.id,
    };
  },

  methods: {
    onChange(e) {
      this.file = e.target.files[0];
    },
    submit() {
      let form = new FormData();
      form.append("file", this.file);
      form.append("date", this.date);
      form.append("trainingName", this.trainingName);

      axios
        .post(`/training-record/${this.employee_id}`, form)
        .then((response) => {
          this.$notify({ message: "Uploaded SuccessFully" });
          this.$refs.fileupload.value = null;
          this.docName = "";
          this.$emit("reloadData");
        })
        .catch((e) => {
          this.errors = e.response.data.errors;
        });
    },
    destroy(doc) {
      if (confirm("Are you sure?")) {
        axios
          .delete(`/remove-training/${doc.id}`)
          .then(() => {
            this.$emit("reloadData");
            this.$notify({ message: "Deleted", type: "warning" });
          });
      }
    },
    view(doc) {
      window.open("/View/" + doc.id, "_blank");
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