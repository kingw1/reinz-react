import React from "react";

export default function Filter() {
    return (
        <>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <div className="d-flex flex-column justify-content-center">
                    <i className="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span className="path1"></span>
                        <span className="path2"></span>
                    </i>
                    <input
                        type="text"
                        className="form-control form-control-solid w-250px ps-13"
                        placeholder="Search Project"
                    />
                </div>
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <select className="form-select form-select-solid">
                    <option value="">Select Project Type</option>
                </select>
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <select className="form-select form-select-solid">
                    <option value="">Select Developer</option>
                </select>
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <select className="form-select form-select-solid">
                    <option value="">Select City</option>
                </select>
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <select className="form-select form-select-solid">
                    <option value="">Select District</option>
                </select>
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <select className="form-select form-select-solid">
                    <option value="">Select Area</option>
                </select>
            </div>
        </>
    );
}
