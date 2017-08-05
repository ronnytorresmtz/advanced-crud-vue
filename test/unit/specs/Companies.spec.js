import Companies from '@/pages/Companies';
import Vue from 'vue';

describe('Compaones.vue', () => {
  it('displays items from the store', () => {
      // build component
    const Constructor = Vue.extend(Companies);
    const CompaniesComponent = new Constructor().$mount();
    // assert that component text contains items from the list
    expect(CompaniesComponent.$el.textContent).to.contain('Galon Transportes');
  });
});

