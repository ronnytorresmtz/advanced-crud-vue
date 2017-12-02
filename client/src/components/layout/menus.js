export default [
  {
    name: 'Dashboard',
    link: '/dashboard',
    icon: 'fa fa-tachometer',
    child: [
      {
        name: 'Dashboard',
        link: '/dashboard',
        icon: 'fa fa-building',
      },
    ],
  },
  {
    name: 'Catalogs',
    link: '',
    icon: 'fa fa-cubes',
    child: [
      {
        name: 'Companies',
        link: '/companies',
        icon: 'fa fa-building',
      },
      {
        name: 'Customers',
        link: '/customers',
        icon: 'fa fa-user',
      },
      {
        name: 'Warehouses',
        link: '/warehouses',
        icon: 'fa fa-user',
      },
    ],
  },
  {
    name: 'Admin',
    link: '#',
    icon: 'fa fa-cog',
  },
  {
    name: 'Help',
    link: '#',
    icon: 'fa fa-question-circle',
  },
];
