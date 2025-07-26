import './bootstrap';
import "@radix-ui/themes/styles.css";
import React from "react";
import { createRoot } from 'react-dom/client';
import { Theme } from '@radix-ui/themes';
import AdminDashboard from './components/admin-dashboard';
import AdminUsers from './components/admin-users';
import AdminComments from './components/admin-comments';

const x = document.getElementById('admin-dashboard-root');
if (x) {
    createRoot(x).render(
        <Theme accentColor="brown" grayColor="gray" scaling="90%">
            <AdminDashboard />
        </Theme>
    );
}

const y = document.getElementById('admin-users-root');
if (y) {
    createRoot(y).render(
        <Theme accentColor="brown" grayColor="gray" scaling="90%">
            <AdminUsers />
        </Theme>
    );
}

const z = document.getElementById('admin-comments-root');
if (z) {
    createRoot(z).render(
        <Theme accentColor="brown" grayColor="gray" scaling="90%">
            <AdminComments />
        </Theme>
    );
}