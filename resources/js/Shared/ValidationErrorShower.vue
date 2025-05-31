<template>
  <div v-if="Object.keys($page.props.errors).length" class="container">
      <n-alert
          class="my-1"
          v-for="(messages, field) in $page.props.errors" 
          :key="field"  
          :title="`Error in ${field}`" 
          type="error"
      >
          <ul v-if="Array.isArray(messages)">
              <li v-for="(message, index) in messages" :key="index">
                  {{ message }}
              </li>
          </ul>
          <p v-else>{{ messages }}</p> <!-- Handles case where message is a string -->
      </n-alert>
  </div>
</template>

<script setup>
import { NAlert } from 'naive-ui';
</script>