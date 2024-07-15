import React from "react";
import { usePage } from "@inertiajs/react";

export default function Sidebar() {
    const permissions = usePage().props.auth.permissions;

    return (
        <div
            id="kt_app_sidebar"
            className="app-sidebar flex-column"
            data-kt-drawer="true"
            data-kt-drawer-name="app-sidebar"
            data-kt-drawer-activate="{default: true, lg: false}"
            data-kt-drawer-overlay="true"
            data-kt-drawer-width="225px"
            data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
        >
            <div className="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                <a href="/admin/dashboard">
                    <img
                        alt="Reinz"
                        src="/img/logo.svg"
                        className="h-50px app-sidebar-logo-default"
                    />
                    <img
                        alt="Reinz"
                        src="/img/logo.svg"
                        className="h-30px app-sidebar-logo-minimize"
                    />
                </a>
                <div
                    id="kt_app_sidebar_toggle"
                    className="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                    data-kt-toggle="true"
                    data-kt-toggle-state="active"
                    data-kt-toggle-target="body"
                    data-kt-toggle-name="app-sidebar-minimize"
                >
                    <i className="ki-duotone ki-black-left-line fs-3 rotate-180">
                        <span className="path1" />
                        <span className="path2" />
                    </i>
                </div>
            </div>
            <div className="app-sidebar-menu overflow-hidden flex-column-fluid">
                {/*begin::Menu wrapper*/}
                <div
                    id="kt_app_sidebar_menu_wrapper"
                    className="app-sidebar-wrapper"
                >
                    {/*begin::Scroll wrapper*/}
                    <div
                        id="kt_app_sidebar_menu_scroll"
                        className="scroll-y my-5 mx-3"
                        data-kt-scroll="true"
                        data-kt-scroll-activate="true"
                        data-kt-scroll-height="auto"
                        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                        data-kt-scroll-wrappers="#kt_app_sidebar_menu"
                        data-kt-scroll-offset="5px"
                        data-kt-scroll-save-state="true"
                    >
                        {/*begin::Menu*/}
                        <div
                            className="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                            id="#kt_app_sidebar_menu"
                            data-kt-menu="true"
                            data-kt-menu-expand="false"
                        >
                            <div className="menu-item">
                                <a
                                    href="/admin/dashboard"
                                    className="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                >
                                    <span className="menu-icon">
                                        <i className="ki-duotone ki-element-11 fs-2">
                                            <span className="path1" />
                                            <span className="path2" />
                                            <span className="path3" />
                                            <span className="path4" />
                                        </i>
                                    </span>
                                    <span className="menu-title">
                                        Dashboards
                                    </span>
                                </a>
                            </div>
                            {permissions.includes("agents-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/agents"
                                        className="menu-link {{ request()->routeIs('admin.agents') ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-profile-user fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                                <span className="path3" />
                                                <span className="path4" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Agents
                                        </span>
                                    </a>
                                </div>
                            )}
                            {permissions.includes("developers-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/developers"
                                        className="menu-link {{ request()->routeIs('admin.developers') ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-bank fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Developers
                                        </span>
                                    </a>
                                </div>
                            )}
                            {permissions.includes("projects-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/projects"
                                        className="menu-link {{ request()->segment(2) === 'projects' ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-abstract-41 fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Projects
                                        </span>
                                    </a>
                                </div>
                            )}
                            {permissions.includes("properties-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/properties"
                                        className="menu-link {{ request()->segment(2) === 'properties' ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-element-plus fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                                <span className="path3" />
                                                <span className="path4" />
                                                <span className="path5" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Properties
                                        </span>
                                    </a>
                                </div>
                            )}
                            <div className="menu-item pt-5">
                                <div className="menu-content">
                                    <span className="menu-heading fw-bold text-uppercase fs-7">
                                        Contacts
                                    </span>
                                </div>
                            </div>
                            <div className="menu-item">
                                <a
                                    href="/admin/property-contacts"
                                    className="menu-link {{ request()->routeIs('admin.property-contacts') ? 'active' : '' }}"
                                >
                                    <span className="menu-icon">
                                        <i className="ki-duotone ki-messages fs-2">
                                            <span className="path1" />
                                            <span className="path2" />
                                            <span className="path3" />
                                            <span className="path4" />
                                            <span className="path5" />
                                        </i>
                                    </span>
                                    <span className="menu-title">
                                        Property Contacts
                                    </span>
                                </a>
                            </div>
                            <div className="menu-item">
                                <a
                                    href="/admin/property-register-form"
                                    className="menu-link {{ request()->routeIs('admin.property-register-form') ? 'active' : '' }}"
                                >
                                    <span className="menu-icon">
                                        <i className="ki-duotone ki-messages fs-2">
                                            <span className="path1" />
                                            <span className="path2" />
                                            <span className="path3" />
                                            <span className="path4" />
                                            <span className="path5" />
                                        </i>
                                    </span>
                                    <span className="menu-title">
                                        Property Register Form
                                    </span>
                                </a>
                            </div>
                            <div className="menu-item pt-5">
                                <div className="menu-content">
                                    <span className="menu-heading fw-bold text-uppercase fs-7">
                                        Settings
                                    </span>
                                </div>
                            </div>
                            {permissions.includes("cities-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/cities"
                                        className="menu-link {{ request()->routeIs('admin.cities') ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-gear fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Cities
                                        </span>
                                    </a>
                                </div>
                            )}
                            {permissions.includes("districts-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/districts"
                                        className="menu-link {{ request()->routeIs('admin.districts') ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-gear fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Districts
                                        </span>
                                    </a>
                                </div>
                            )}
                            {permissions.includes("areas-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/areas"
                                        className="menu-link {{ request()->routeIs('admin.areas') ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-gear fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Areas
                                        </span>
                                    </a>
                                </div>
                            )}
                            <div className="menu-item">
                                <a
                                    href="/admin/project-types"
                                    className="menu-link {{ request()->routeIs('admin.project-types') ? 'active' : '' }}"
                                >
                                    <span className="menu-icon">
                                        <i className="ki-duotone ki-gear fs-2">
                                            <span className="path1" />
                                            <span className="path2" />
                                        </i>
                                    </span>
                                    <span className="menu-title">
                                        Project Types
                                    </span>
                                </a>
                            </div>
                            <div className="menu-item">
                                <a
                                    href="/admin/seo"
                                    className="menu-link {{ request()->routeIs('admin.seo') ? 'active' : '' }}"
                                >
                                    <span className="menu-icon">
                                        <i className="ki-duotone ki-gear fs-2">
                                            <span className="path1" />
                                            <span className="path2" />
                                        </i>
                                    </span>
                                    <span className="menu-title">SEO</span>
                                </a>
                            </div>

                            <div className="menu-item pt-5">
                                <div className="menu-content">
                                    <span className="menu-heading fw-bold text-uppercase fs-7">
                                        Users
                                    </span>
                                </div>
                            </div>
                            {permissions.includes("roles-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/roles"
                                        className="menu-link {{ request()->routeIs('admin.roles') ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-gear fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Roles &amp; Permissions
                                        </span>
                                    </a>
                                </div>
                            )}
                            {permissions.includes("users-index") && (
                                <div className="menu-item">
                                    <a
                                        href="/admin/users"
                                        className="menu-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"
                                    >
                                        <span className="menu-icon">
                                            <i className="ki-duotone ki-gear fs-2">
                                                <span className="path1" />
                                                <span className="path2" />
                                            </i>
                                        </span>
                                        <span className="menu-title">
                                            Users
                                        </span>
                                    </a>
                                </div>
                            )}
                        </div>
                        {/*end::Menu*/}
                    </div>
                    {/*end::Scroll wrapper*/}
                </div>
                {/*end::Menu wrapper*/}
            </div>
            {/*end::sidebar menu*/}
        </div>
    );
}
