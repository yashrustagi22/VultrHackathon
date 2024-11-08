<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card mt-5">
          <div class="card-header text-center">
            <h2>Login to Your Account</h2>
          </div>
          <div class="card-body">
            <form @submit.prevent="login">
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="email"
                  required
                  placeholder="Enter your email"
                />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  v-model="password"
                  required
                  placeholder="Enter your password"
                />
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="mt-3 text-center">
              <router-link to="/register">Don't have an account? Register here</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password,
        });
        // Handle successful login, e.g., redirect to dashboard
        this.$router.push('/home'); // Adjust this based on your routes
      } catch (error) {
        console.error('Login error:', error.response);
        alert('Login failed! Please check your credentials and try again.'); // Show error message
      }
    }
  }
};
</script>

<style scoped>
.container {
  background-color: #f4f6f9;
  height: 100vh;
}
.card {
  border: none;
  border-radius: 10px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
.card-header {
  background-color: #007bff;
  color: white;
  border-radius: 10px 10px 0 0;
}
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}
.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}
</style>
