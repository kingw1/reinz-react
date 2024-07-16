import AdminLayout from "@/Layouts/AdminLayout";
import { Head, usePage } from "@inertiajs/react";
import React from "react";

export default function Dashboard() {
    const user = usePage().props.auth.user;

    return (
        <AdminLayout headline={"Welcome, " + user.name}>
            <Head title="Admin Panel" />
        </AdminLayout>
    );
}
