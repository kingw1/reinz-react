import React, { useEffect } from "react";
import { Head, usePage, useForm } from "@inertiajs/react";
import Swal from "sweetalert2";

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: "",
        password: "",
    });

    const { flash } = usePage().props;

    useEffect(() => {
        flash.message &&
            Swal.fire({
                title: flash.message,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-danger",
                },
            });
    }, [flash]);

    function handleSubmit(e) {
        e.preventDefault();
        post("/admin/authenticate");
    }

    return (
        <>
            <Head title="Login to admin control panel" />

            <div className="d-flex flex-column flex-column-fluid flex-lg-row">
                <div className="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                    <div className="d-flex flex-center flex-lg-start flex-column">
                        <a className="mb-7" href="/admin/login">
                            <img
                                alt="Reinz"
                                className="h-50px"
                                src="/img/logo.svg"
                            />
                        </a>
                        <h2 className="text-white fw-normal m-0">
                            Branding tools designed for your business
                        </h2>
                    </div>
                </div>
                <div className="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                    <div className="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                        <div className="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                            <form
                                onSubmit={handleSubmit}
                                className="form w-100"
                            >
                                <div className="text-center mb-11">
                                    <h1 className="text-dark fw-bolder mb-3">
                                        Sign In
                                    </h1>
                                </div>
                                <div className="fv-row mb-8">
                                    <input
                                        autoComplete="off"
                                        autoFocus
                                        className="form-control bg-transparent"
                                        name="email"
                                        placeholder="Email"
                                        type="email"
                                        value={data.email}
                                        onChange={(e) =>
                                            setData("email", e.target.value)
                                        }
                                    />

                                    {errors.email && <div>{errors.email}</div>}
                                </div>
                                <div className="fv-row mb-3">
                                    <input
                                        autoComplete="off"
                                        className="form-control bg-transparent"
                                        name="password"
                                        placeholder="Password"
                                        type="password"
                                        value={data.password}
                                        onChange={(e) =>
                                            setData("password", e.target.value)
                                        }
                                    />

                                    {errors.password && (
                                        <div>{errors.password}</div>
                                    )}
                                </div>
                                <div className="d-grid my-10">
                                    <button
                                        className="btn btn-primary"
                                        id="kt_sign_in_submit"
                                        type="submit"
                                    >
                                        <span className="indicator-label">
                                            Sign In
                                        </span>

                                        {processing && (
                                            <span className="indicator-progress">
                                                Please wait...
                                                <span className="spinner-border spinner-border-sm align-middle ms-2" />
                                            </span>
                                        )}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
