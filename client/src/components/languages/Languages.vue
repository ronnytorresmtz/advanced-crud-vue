<script>
// my components
import MyLang from '../languages/Traslations';

export default {
  created() {
    this.ts = this.getLang();
  },

  data() {
    return {
      ts: '',
      locale: 'en',
    };
  },

  methods: {
    getLang() {
      return MyLang[this.locale];
    },

    setLocale(e) {
      this.locale = e.target.value;
      this.ts = this.getLang();
    },
  },
};
</script>
