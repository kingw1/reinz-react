import CreateButton from "@/Components/CreateButton";
import DeleteButton from "@/Components/DeleteButton";
import EditButton from "@/Components/EditButton";
import Pagination from "@/Components/Pagination";
import AdminLayout from "@/Layouts/AdminLayout";
import { Head, usePage } from "@inertiajs/react";
import React from "react";
import Filter from "./Filter";

export default function Index({ projects }) {
    const permissions = usePage().props.auth.permissions;

    function createProject() {
        window.location.href = "/admin/projects/create";
    }

    function deleteProject() {
        alert("Delete project");
    }

    const actionButton = (
        <CreateButton onClick={createProject}>Create Project</CreateButton>
    );

    return (
        <AdminLayout headline="Projects" action={actionButton}>
            <Head title="Projects" />
            <div className="card card-flush">
                <div className="card-header mt-6">
                    <div className="card-title">
                        <Filter />
                    </div>
                </div>
                <div className="card-body pt-0">
                    <table className="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                            <tr className="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>Name En</th>
                                <th>Name Kh</th>
                                <th>Project Type</th>
                                <th>Developer</th>
                                <th>Status</th>
                                <th>Date & Time</th>

                                {permissions.includes("projects-edit") ||
                                permissions.includes("projects-delete") ? (
                                    <th className="text-end min-w-100px">
                                        Actions
                                    </th>
                                ) : (
                                    ""
                                )}
                            </tr>
                        </thead>
                        <tbody className="fw-semibold text-gray-600">
                            {projects.data.map((project) => {
                                return (
                                    <tr key={project.id}>
                                        <td>{project.name_en}</td>
                                        <td>{project.name_kh}</td>
                                        <td>{project.project_type}</td>
                                        <td>{project.developer}</td>
                                        <td>{project.status}</td>
                                        <td>{project.created_at}</td>

                                        {permissions.includes(
                                            "projects-edit"
                                        ) ||
                                        permissions.includes(
                                            "projects-delete"
                                        ) ? (
                                            <td className="text-end">
                                                {permissions.includes(
                                                    "projects-edit"
                                                ) && (
                                                    <EditButton
                                                        href={`/admin/projects/${project.id}/edit`}
                                                    />
                                                )}

                                                {permissions.includes(
                                                    "projects-delete"
                                                ) && (
                                                    <DeleteButton
                                                        onClick={deleteProject}
                                                    />
                                                )}
                                            </td>
                                        ) : (
                                            ""
                                        )}
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                    <Pagination source={projects} />
                </div>
            </div>
        </AdminLayout>
    );
}
