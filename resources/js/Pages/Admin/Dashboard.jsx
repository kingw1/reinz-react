import AdminLayout from "@/Layouts/AdminLayout";
import { Head } from "@inertiajs/react";
import React from "react";

export default function Dashboard() {
    return (
        <AdminLayout>
            <Head title="Admin Panel" />

            <div>Dashboard</div>
        </AdminLayout>
    );
}
