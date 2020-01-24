<template>
  <div class="d-flex justify-content-center align-content-center bg-light flex-column h-100">
    <h1 class="my-3 text-secondary display-3 w-auto mx-auto">PHARMA</h1>
    <b-form @submit.prevent="Log">
      <b-form-group
        class="mx-auto"
        label="Authenticate"
        label-class="text-center text-secondary lead"
        style="width: 400px;"
      >
        <b-form-input
          id="name"
          v-model="userlogin"
          type="text"
          required
          placeholder="Login"
          class="my-2"
        ></b-form-input>

        <b-form-input
          id="pass"
          v-model="userpass"
          type="text"
          required
          placeholder="Password"
          class="my-2"
          :is-valid="validate"
        ></b-form-input>
      </b-form-group>

      <div class="d-flex justify-content-center my-3">
        <b-button type="submit" variant="info" style="min-width:70px;">Save</b-button>
      </div>
    </b-form>
  </div>
</template>

<script>
export default {
  // <img src="./storage/images/LOGO.png" class="my-3" />
  name: "Login",
  title: "Login",
  data: function() {
    return {
      userlogin: null,
      userpass: null
    };
  },
  methods: {
    validate() {
      return (
        this.userlogin.trim() == this.login &&
        this.password.trim() == this.userpass
      );
    },
    Log() {
      if (this.validate()) {
        this.$store.commit("setLogged", true);
        this.$router.push("/home");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
