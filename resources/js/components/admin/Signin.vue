<template>
  <div>
    <v-layout mb-4 mt-4 style="display: grid; align-items: center; height: 80vh;">
      <v-flex sm6 offset-sm3 xs10 offset-xs1>
        <v-card class="container" id="container">
          <div class="form-container sign-in-container">
            <form @submit.prevent="signIn()">
              <h1>Sign In</h1>
              <div class="social-container">
                <a href class="social">
                  <v-icon>fab fa-facebook-f</v-icon>
                </a>
                <a href class="social">
                  <v-icon>fab fa-facebook-f</v-icon>
                </a>
                <a href class="social">
                  <v-icon>fab fa-facebook-f</v-icon>
                </a>
              </div>
              <span>or use your account</span>
              <input type="email" placeholder="Email" id="username" v-model="admin.username">
              <input type="password" placeholder="Password" id="password" v-model="admin.password">
              <button>Sign In</button>
            </form>
          </div>

          <div class="form-container sign-up-container">
            <form action>
              <h1>Create Account</h1>
              <div class="social-container">
                <a href class="social">
                  <v-icon>fab fa-facebook-f</v-icon>
                </a>
                <a href class="social">
                  <v-icon>fab fa-facebook-f</v-icon>
                </a>
                <a href class="social">
                  <v-icon>fab fa-facebook-f</v-icon>
                </a>
              </div>
              <span>or use your email for registration</span>
              <input type="text" placeholder="Name">
              <input type="email" placeholder="Email">
              <input type="password" placeholder="Password">
              <button>Sign Up</button>
            </form>
          </div>

          <div class="overlay-container">
            <div class="overlay">
              <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn" @click="showSignIn()">Sign In</button>
              </div>
              <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp" @click="showSignUp()">Sign Up</button>
              </div>
            </div>
          </div>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
export default {
  data() {
    return {
      admin: {
        username: "",
        password: ""
      },
      showPass: false
    };
  },
  created() {
    this.load_admin();
  },
  methods: {
    load_admin() {
      this.$store.dispatch("load_admin");
    },
    showSignIn() {
      const container = document.getElementById("container");
      container.classList.remove("right-panel-active");
    },
    showSignUp() {
      const container = document.getElementById("container");
      container.classList.add("right-panel-active");
    },
    signIn() {
      this.$store
        .dispatch("retrieveToken_admin", {
          username: this.admin.username,
          password: this.admin.password
        })
        .then(response => {
          this.$router.push("/admin/");
        });
    }
  }
};
</script>

<style scoped>
h1 {
  font-weight: bold;
  margin: 0;
}

p {
  font-size: 14px;
  font-weight: 100;
  line-height: 20px;
  letter-spacing: 0.5px;
  margin: 20px 0 30px;
}

span {
  font-size: 12px;
}

a {
  color: #333;
  font-size: 14px;
  text-decoration: none;
  margin: 15px 0;
}

button {
  border-radius: 20px;
  border: 1px solid #000000;
  background-color: #000000;
  color: #ffffff;
  font-size: 12px;
  font-weight: bold;
  padding: 12px 45px;
  margin-top: 5px;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 80ms ease-in;
}

button:active {
  transform: scale(0.95);
}

button:focus {
  outline: none;
}

button.ghost {
  background-color: transparent;
  border-color: #ffffff;
}

form {
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 50px;
  height: 100%;
  text-align: center;
}

input {
  background-color: #eee;
  border: none;
  padding: 12px 15px;
  margin: 8px 0;
  width: 100%;
}

.social-container {
  margin: 20px 0;
}

.social-container a {
  border: 1px solid #dddddd;
  border-radius: 50%;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  margin: 0 5px;
  height: 40px;
  width: 40px;
}

.container {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  position: relative;
  overflow: hidden;
  width: 768px;
  max-width: 100%;
  min-height: 480px;
}

.form-container {
  position: absolute;
  top: 0;
  height: 100%;
  transition: all 0.6s ease-in-out;
}

.sign-in-container {
  left: 0;
  width: 50%;
  z-index: 2;
}

.sign-up-container {
  left: 0;
  width: 50%;
  opacity: 0;
  z-index: 1;
}

.container.right-panel-active .sign-in-container {
  transform: translateX(100%);
}

.container.right-panel-active .sign-up-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 5;
  animation: show 0.6s;
}

.overlay-container {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
}

.container.right-panel-active .overlay-container {
  transform: translateX(-100%);
}

.overlay {
  background: #ff416c;
  background: linear-gradient(to right, #4c4c4c, #000000);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 0 0;
  color: #ffffff;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
  transform: translateX(50%);
}

.overlay-panel {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 40px;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

.overlay-left {
  transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
  transform: translateX(0);
}

.overlay-right {
  right: 0;
  transform: translateX(0);
}

.container.right-panel-active .overlay-right {
  transform: translateX(20%);
}
</style>



