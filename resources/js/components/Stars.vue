<template>
  <div class="flex">
    <div
      v-for="star in getStars(rating, quantity)"
      :class="[color ? color : defaultColor]"
      :key="star.id"
    >
      <i class="fas fa-star" v-if="star === 1"></i>
      <i class="fas fa-star-half-alt" v-if="star === 0.5"></i>
      <i class="far fa-star" v-if="star === 0"></i>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    rating: {
      type: Number
    },
    color: {
      type: String,
      default: "text-indigo-400"
    },
    quantity: {
      type: Number,
      default: 5
    }
  },

  methods: {
    getStars: function(rating, quantity) {
      let stars = [];

      for (let i = 0; i < quantity; i++) {
        if (rating >= 0.5) {
          rating = rating - 1;
          stars.push(1);
        } else if (rating > 0) {
          stars.push(0.5);
          rating = 0;
        } else if (i < quantity) {
          stars.push(0);
        }
      }
      return stars;
    }
  }
};
</script>

