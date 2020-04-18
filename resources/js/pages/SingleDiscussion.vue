<template>
  <div v-if="discussion">
    <div class="head">
      <h1 class="inline-block text-4xl">{{ discussion.title }}</h1>
      <span class="float-right mt-2">
        Posted In
        <span
          class="rounded-full bg-red-500 text-white font-bold text-sm py-1 px-2"
        >{{ discussion.channel.title }}</span>
      </span>
    </div>
    <div class="body mt-4">
      <div class="container mx-auto bg-white flex mb-1 p-3">
        <div class="bg-white w-1/12 self-center">
          <img
            src="https://randomuser.me/api/portraits/men/17.jpg"
            alt="avatar"
            class="rounded-full h-16"
          />
        </div>
        <div class="bg-white flex-grow">
          <h3 class="font-bold text-lg mt-2">
            {{ discussion.user.name }}
            <span class="text-gray-500 text-sm">
              {{
              discussion.published_at
              }}
            </span>
          </h3>
          <p class="text-gray-600 text-sm mt-6" v-html="discussion.content"></p>
        </div>
      </div>
      <div
      v-for="reply in discussion.replies"
      :key="reply.id"
      class="container mx-auto bg-white flex mb-1 p-3">
        <div class="bg-white w-1/12 self-center">
          <img
            src="https://randomuser.me/api/portraits/men/17.jpg"
            alt="avatar"
            class="rounded-full h-16"
          />
        </div>
        <span class="bg-white flex-grow">
          <h3 class="font-bold text-lg mt-2">
            {{ reply.user }}
            <span class="text-gray-500 text-sm">
              {{
              reply.published_at
              }}
            </span>
          </h3>
          <p class="text-gray-600 text-sm mt-6" v-html="reply.content"></p>
        </span>
      </div>
      <div>
        <yimo-vue-editor v-model="reply"></yimo-vue-editor>
        <button
          class="bg-btnBlueColor text-white py-2 px-4 rounded-full uppercase text-sm"
          @click="storeReply"
        >Reply</button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import YimoVueEditor from "yimo-vue-editor";

export default {
  data() {
    return {
      reply: ""
    };
  },
  components: {
    YimoVueEditor
  },
  mounted() {
    this.$store.dispatch(
      "forum/fetchDiscussion",
      this.$route.params.discussion
    );
  },
  computed: {
    ...mapGetters("forum", ["discussion"])
  },
  methods: {
    storeReply() {
      this.$store.dispatch("forum/storeReply", {
        content: this.reply,
        discussion_id: this.discussion.id,
        user_id: this.$store.getters["auth/user"].id
      });
      this.reply = "";
    }
  }
};
</script>
