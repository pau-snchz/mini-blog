import './bootstrap';
import "@radix-ui/themes/styles.css";
import React from "react";
import { createRoot } from 'react-dom/client';
import { Theme } from '@radix-ui/themes';
import AdminDashboard from './components/admin-dashboard';
import AdminUsers from './components/admin-users';
// import AdminComments from './components/admin-comments';

const el = document.getElementById('admin-dashboard-root');
if (el) {
    createRoot(el).render(
        <Theme >
            <AdminDashboard />
            <AdminUsers />
        </Theme>
    );
}
