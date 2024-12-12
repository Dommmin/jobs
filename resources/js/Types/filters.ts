export interface Filters {
    search: string;
    location: string;
    experience: string;
    contract: string;
    specialization: string;
    workType: string;
    sortOrder: string;
}

export interface FilterOption {
    slug: string;
    name: string;
}
