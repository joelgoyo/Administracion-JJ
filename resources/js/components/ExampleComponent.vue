<template>
  <nav-component />
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">
            I'm an example component.
            <table class="table">
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
              <tr v-for="user in users.data">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import navComponent from "./navComponent.vue";
import axios from "axios";
export default {
  components: { navComponent },
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    console.log("Component mounted.");
    axios.get("/api/users").then((response) => {
      this.users = response.data;
      console.log(response.data);
    });
  },
};
</script>
