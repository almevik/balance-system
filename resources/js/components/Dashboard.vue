<template>
  <div class="container mt-5">
    <h2 v-if="user">Добро пожаловать, {{ user.name }}!</h2>
    <p>Текущий баланс: <strong>{{ balance }}</strong></p>
    <h3>Последние операции</h3>
    <ul class="list-group">
      <li
          v-for="(transaction, index) in transactions"
          :key="index"
          class="list-group-item d-flex justify-content-between"
      >
        <span>{{ transaction.amount }} - {{ transaction.description }}</span>
        <small>{{ formatDate(transaction.transaction_date) }}</small>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: null,
      balance: 0,
      transactions: [],
      interval: null,
    };
  },
  mounted() {
    this.fetchData();
    this.interval = setInterval(this.fetchData, 5000); // Обновление каждые 5 секунд
  },
  beforeUnmount() {
    clearInterval(this.interval);
  },
  methods: {
    async fetchData() {
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/balance-and-transactions', {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.user = response.data.user;
        this.balance = response.data.balance;
        this.transactions = response.data.transactions;
      } catch (error) {
        console.error('Ошибка получения данных:', error);
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleString();
    },
  },
};
</script>

<style scoped>
.list-group-item {
  font-size: 14px;
}
</style>
