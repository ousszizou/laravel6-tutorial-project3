<template>
  <div class="container mx-auto bg-gray-200 flex font-sans">
    <div class="w-1/5 bg-gray-300 text-center p-6">
      <button
        class="bg-btnBlueColor text-white py-2 px-4 rounded-full uppercase w-full text-sm"
        @click="ShowStoreDiscussionModal"
      >
        ask a question
      </button>
      <modal name="storeDiscussionModal" height="630">
        <h1 class="text-3xl">New Question/Discussion</h1>
        <p>Fill out the information below to begin your new discussion.</p>
        <form @submit.prevent="storeDiscussion">
          <input
            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500 mb-2"
            type="text"
            placeholder="Title of Discussion"
            v-model="dataForm.title"
          />
          <select
            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
            v-model="dataForm.channel_id"
          >
            <option>Select a Channel</option>
            <option
              v-for="channel in channels.data"
              :key="channel.id"
              :value="channel.id"
              >{{ channel.title }}</option
            >
          </select>
          <vue-editor v-model="dataForm.content"></vue-editor>
          <input type="hidden" :value="dataForm.content" />
          <button
            class="bg-gray-700 text-white py-2 px-4 rounded-full uppercase text-sm"
            @click="HideStoreDiscussionModal"
          >
            cancel
          </button>
          <button
            class="bg-btnBlueColor text-white py-2 px-4 rounded-full uppercase text-sm"
            type="submit"
          >
            new discussion
          </button>
        </form>
      </modal>
      <a href="#" class="my-4 block font-black capitalize">all discussions</a>
      <ul>
        <li v-for="channel in channels.data" :key="channel.id">
          <a href="#"> {{ channel.title }} </a>
        </li>
      </ul>
    </div>
    <div class="w-4/5 bg-blue-300 p-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import { VueEditor, Quill } from "vue2-editor";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      dataForm: {
        title: "",
        content: "",
        channel_id: ""
      }
    };
  },
  components: {
    VueEditor
  },
  mounted() {
    this.$store.dispatch("forum/fetchChannels");
    this.$store.dispatch("auth/fetchUser");
  },
  computed: {
    ...mapGetters({
      user: "auth/user",
      channels: "forum/channels"
    })
  },
  methods: {
    ShowStoreDiscussionModal() {
      this.$modal.show("storeDiscussionModal");
    },
    HideStoreDiscussionModal() {
      this.$modal.hide("storeDiscussionModal");
    },
    storeDiscussion() {
      let data = {
        title: this.dataForm.title,
        content: this.dataForm.content,
        channel_id: this.dataForm.channel_id,
        user_id: this.user.id
      };
      this.$store.dispatch("forum/storeDiscussion", data);
      this.$store.dispatch("forum/fetchDiscussions");
    }
  }
};
</script>
