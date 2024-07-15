import React from "react";
import Header from "./Admin/Header";
import Sidebar from "./Admin/Sidebar";
import { usePage } from "@inertiajs/react";

export default function AdminLayout({ children }) {
    const user = usePage().props.auth.user;

    return (
        <div className="d-flex flex-column flex-root app-root" id="kt_app_root">
            <div
                className="app-page flex-column flex-column-fluid"
                id="kt_app_page"
            >
                <Header user={user} />
                <div
                    className="app-wrapper flex-column flex-row-fluid"
                    id="kt_app_wrapper"
                >
                    <Sidebar />

                    <div
                        className="app-main flex-column flex-row-fluid"
                        id="kt_app_main"
                    >
                        <div className="d-flex flex-column flex-column-fluid">
                            <div
                                id="kt_app_toolbar"
                                className="app-toolbar py-3 py-lg-6"
                            >
                                <div
                                    id="kt_app_toolbar_container"
                                    className="app-container container-xxl d-flex justify-content-between"
                                >
                                    <h1 className="page-heading text-dark fw-bold fs-3 my-0">
                                        headline
                                    </h1>
                                    <div>action</div>
                                </div>
                            </div>
                            <div
                                id="kt_app_content"
                                className="app-content flex-column-fluid"
                            >
                                <div
                                    id="kt_app_content_container"
                                    className="app-container container-xxl mb-10"
                                >
                                    {children}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
