<template>
  <div class="container mt-5">
    <h2>История операций</h2>
    <div class="mb-3">
      <input
          type="text"
          class="form-control"
          placeholder="Поиск по описанию"
          v-model="searchQuery"
          @input="fetchTransactions"
      />
    </div>
    <table class="table table-striped">
      <thead>
      <tr>
        <th @click="sort('amount')">Сумма</th>
        <th @click="sort('description')">Описание</th>
        <th @click="sort('transaction_date')">Дата</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="transaction in transactions" :key="transaction.id">
        <td>{{ transaction.amount }}</td>
        <td>{{ transaction.description }}</td>
        <td>{{ formatDate(transaction.transaction_date) }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      transactions: [],
      searchQuery: '',
      sortField: 'transaction_date',
      sortOrder: 'desc',
    };
  },
  methods: {
    async fetchTransactions() {
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/transactions', {
          params: {
            search: this.searchQuery,
            sort: this.sortField,
            order: this.sortOrder,
          },
          headers: {Authorization: `Bearer ${token}`},
        });
        this.transactions = response.data.data;
      } catch (error) {
        console.error('Ошибка получения истории:', error);
      }
    },
    sort(field) {
      if (this.sortField === field) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortField = field;
        this.sortOrder = 'asc';
      }
      this.fetchTransactions();
    },
    formatDate(date) {
      return new Date(date).toLocaleString();
    },
  },
  mounted() {
    this.fetchTransactions();
  },
};
</script>

<style scoped>
th {
  cursor: pointer;
}
</style>
