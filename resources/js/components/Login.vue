<template>
  <div class="login-container">
    <div class="login-form">
      <h2>Вход</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input
              type="email"
              id="email"
              class="form-control"
              v-model="email"
              required
          />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Пароль:</label>
          <input
              type="password"
              id="password"
              class="form-control"
              v-model="password"
              required
          />
        </div>
        <button type="submit" class="btn btn-primary w-100">Войти</button>
        <div v-if="error" class="text-danger mt-2">{{ error }}</div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: '',
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password,
        });
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('user', response.data.user);

        this.$router.push('/dashboard');
      } catch (error) {
        this.error = 'Неверные учетные данные';
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-form {
  width: 300px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}
</style>
