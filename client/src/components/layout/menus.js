export default [
  {
    name: 'Dashboard',
    link: '/shipper/dashboard',
    icon: 'fa fa-tachometer',
    child: [
      {
        name: 'Orders',
        link: '/shipper/dashboard/orders',
        icon: 'fa fa-bar-chart',
      },
      {
        name: 'Payments',
        link: '/shipper/dashboard/payments',
        icon: 'fa fa-area-chart',
      },
      {
        name: 'Evaluations',
        link: '/shipper/dashboard/evaluations',
        icon: 'fa fa-pie-chart',
      },
    ],
  },
  {
    name: 'Shippers',
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
        link: '/shipper/shippers/warehouses',
        icon: 'fa fa-cube',
      },
    ],
  },
  {
    name: 'Carries',
    link: '#',
    icon: 'fa fa-truck',
    child: [
      {
        name: 'Invitations',
        link: '/shipper/carriers/invitations',
        icon: 'fa fa-envelope',
      },
      {
        name: 'Network',
        link: '/shipper/carriers/network',
        icon: 'fa fa-globe',
      },
    ],
  },
  {
    name: 'Orders',
    link: '#',
    icon: 'fa fa-file',
    child: [
      {
        name: 'Request',
        link: '/shipper/orders/request',
        icon: 'fa fa-file',
      },
      {
        name: 'Pickup & Delivery',
        link: '/shipper/orders/pickupanddeliver',
        icon: 'fa fa-map-marker',
      },
      {
        name: 'Payments',
        link: '/shipper/orders/payments',
        icon: 'fa fa-credit-card',
      },
    ],
  },
  {
    name: 'Admin',
    link: '#',
    icon: 'fa fa-cog',
    child: [
      {
        name: 'Security',
        link: '/shipper/admin/security',
        icon: 'fa fa-lock',
      },
      {
        name: 'Configuration',
        link: '/shipper/admin/configuration',
        icon: 'fa fa-wrench',
      },
      {
        name: 'Preferences',
        link: '/shipper/admin/preferences',
        icon: 'fa fa-coffee',
      },
      {
        name: 'Locations',
        link: '/admin/locations',
        icon: 'fa fa-globe',
      },
    ],
  },
  {
    name: 'Help',
    link: '/shipper/admin/help',
    icon: 'fa fa-question-circle',
  },
];
