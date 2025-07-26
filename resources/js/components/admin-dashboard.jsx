import { useEffect, useState } from "react";
import { Box, Grid, Text, Flex, Heading, Table, Button } from "@radix-ui/themes";

export default function AdminDashboard() {
  const [stats, setStats] = useState({
    users: null,
    posts: null,
    comments: null,
    blockedComments: null,
  });
  const [statsError, setStatsError] = useState(null);
  const [statsLoading, setStatsLoading] = useState(true);

  const [posts, setPosts] = useState([]);
  const [postsError, setPostsError] = useState(null);
  const [postsLoading, setPostsLoading] = useState(true);

  useEffect(() => {
    setStatsLoading(true);
    fetch("/admin/stats")
      .then((res) => {
        if (!res.ok) throw new Error("Stats API error");
        return res.json();
      })
      .then((data) => {
        setStats(data);
        setStatsError(null);
      })
      .catch((e) => {
        setStatsError(e.message);
      })
      .finally(() => setStatsLoading(false));
  }, []);

  useEffect(() => {
    setPostsLoading(true);
    fetch("/admin/posts")
      .then((res) => {
        if (!res.ok) throw new Error("Posts API error");
        return res.json();
      })
      .then((data) => {
        setPosts(data);
        setPostsError(null);
      })
      .catch((e) => {
        setPostsError(e.message);
      })
      .finally(() => setPostsLoading(false));
  }, []);

  // Navigation helpers
  const goTo = (url) => window.location.href = url;

  // Delete handler
  const handleDelete = async (id) => {
    if (!window.confirm("Are you sure you want to delete this post?")) return;
    const res = await fetch(`/admin/posts/${id}`, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "",
          "Accept": "application/json",
        }
    });
    if (res.ok) {
      setPosts(posts.filter(p => p.id !== id));
    } else {
      alert("Failed to delete post.");
    }
  };

  // Debug: log on mount
  useEffect(() => {
    console.log("AdminDashboard mounted");
  }, []);

  return (
    <>
    <Box style={{ backgroundColor: '#ccdee8', height: "100vh", overflowY: "auto", fontFamily: "Geist, sans-serif" }}>
        <Text as="h1" size="6" weight="bold">Dashboard</Text>
        {statsLoading ? (
            <Text>Loading stats...</Text>
        ) : statsError ? (
            <Text color="red">{statsError}</Text>
        ) : (
            <Grid columns={{ initial: "1", md: "2", lg: "4" }} gap="4" mt="5" mb="5">
            <Box className="bg-[#63372c] rounded-xl border-4 border-[#ac764e] text-white min-h-32">
                <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
                <Text size="3" weight="bold" >Users</Text>
                <Text size="7" weight="bold">{stats.users ?? "—"}</Text>
                </Flex>
            </Box>
            <Box className="bg-[#63372c] rounded-xl border-4 border-[#ac764e] text-white min-h-32">
                <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
                <Text size="3" weight="bold">Posts</Text>
                <Text size="7" weight="bold">{stats.posts ?? "—"}</Text>
                </Flex>
            </Box>
            <Box className="bg-[#63372c] rounded-xl border-4 border-[#ac764e] text-white min-h-32">
                <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
                <Text size="3" weight="bold">Comments</Text>
                <Text size="7" weight="bold">{stats.comments ?? "—"}</Text>
                </Flex>
            </Box>
            <Box className="bg-[#63372c] rounded-xl border-4 border-[#ac764e] text-white min-h-32">
                <Flex direction="column" align="center" justify="center" gap="4" style={{ minHeight: "100%" }}>
                <Text size="3" weight="bold">Blocked Comments</Text>
                <Text size="7" weight="bold">{stats.blockedComments ?? "—"}</Text>
                </Flex>
            </Box>
            </Grid>
        )}

        <Heading mb="5" mt="8">Posts</Heading>
        {postsLoading ? (
            <Text>Loading posts...</Text>
        ) : postsError ? (
            <Text color="red">{postsError}</Text>
        ) : (
            <Table.Root variant="surface">
            <Table.Header>
                <Table.Row>
                <Table.ColumnHeaderCell className="w-[60px]">ID</Table.ColumnHeaderCell>
                <Table.ColumnHeaderCell className="truncate max-w-0">Title</Table.ColumnHeaderCell>
                <Table.ColumnHeaderCell className="w-[60px]">Likes</Table.ColumnHeaderCell>
                <Table.ColumnHeaderCell className="w-[210px]">Actions</Table.ColumnHeaderCell>
                </Table.Row>
            </Table.Header>
            <Table.Body>
                {posts.length === 0 ? (
                <Table.Row>
                    <Table.Cell colSpan={4} align="center">No posts found.</Table.Cell>
                </Table.Row>
                ) : posts.map((post) => (
                <Table.Row key={post.id}>
                    <Table.Cell>{post.id}</Table.Cell>
                    <Table.Cell>{post.title}</Table.Cell>
                    <Table.Cell>{post.like_count ?? 0}</Table.Cell>
                    <Table.Cell>
                    <Flex gap="2">
                        <Button size="1" color="blue" variant="soft" onClick={() => goTo(`/blog/${post.id}`)}>
                        Read More
                        </Button>
                        <Button size="1" color="orange" variant="soft" onClick={() => goTo(`/blog/${post.id}/edit`)}>
                        Edit
                        </Button>
                        <Button size="1" color="red" variant="soft" onClick={() => handleDelete(post.id)}>
                        Delete
                        </Button>
                    </Flex>
                    </Table.Cell>
                </Table.Row>
                ))}
            </Table.Body>
            </Table.Root>
        )}
      </Box>
    </>
  );
}