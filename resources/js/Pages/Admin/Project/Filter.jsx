import Select from "@/Components/Select";
import React from "react";

export default function Filter({
    selectProjectTypes,
    selectDevelopers,
    selectCities,
    selectDistricts,
    selectAreas,
    filterData,
    filters,
}) {
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
                        onChange={(e) => filterData("search", e.target.value)}
                        defaultValue={filters.search}
                    />
                </div>
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <Select
                    options={selectProjectTypes}
                    onChange={(e) =>
                        filterData("project_type_id", e.target.value)
                    }
                    selectedOption={filters.project_type_id}
                    defaultOption="Select Project Type"
                />
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <Select
                    options={selectDevelopers}
                    onChange={(e) => filterData("developer_id", e.target.value)}
                    selectedOption={filters.developer_id}
                    defaultOption="Select Developer"
                />
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <Select
                    options={selectCities}
                    onChange={(e) => filterData("city_id", e.target.value)}
                    selectedOption={filters.city_id}
                    defaultOption="Select City"
                />
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <Select
                    options={selectDistricts}
                    onChange={(e) => filterData("district_id", e.target.value)}
                    selectedOption={filters.district_id}
                    defaultOption="Select District"
                />
            </div>
            <div className="d-flex align-items-center position-relative my-1 me-5">
                <Select
                    options={selectAreas}
                    onChange={(e) => filterData("area_id", e.target.value)}
                    selectedOption={filters.area_id}
                    defaultOption="Select Area"
                />
            </div>
        </>
    );
}
