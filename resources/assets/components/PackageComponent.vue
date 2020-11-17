<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">FROM PACKAGE in vendor </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
     console.log('Component mounted.');
  },
  methods: {
    eng() {
      console.log('english');
      const error =';kkk';
      return 'ttttt';
    },
    //
    // de() {
    //   console.log('english');
    //   this.$i18n.locale = 'de';
    // },
  },
};
</script>
